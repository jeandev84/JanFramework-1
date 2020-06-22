<?php
namespace Jan\Component\DI;


use Closure;
use Jan\Component\DI\Contracts\BootableServiceProvider;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\InstanceException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\DI\ServiceProvider\ServiceProvider;
use ReflectionClass;
use ReflectionException;



/**
 * Class Container
 * @package Jan\Component\DI
*/
class Container implements \ArrayAccess, ContainerInterface
{

    /**
     * @var bool
    */
    protected $autowire = true;


    /** @var Container */
    protected static $instance;


    /** @var array  */
    protected $bindings = [];


    /** @var array  */
    protected $instances = [];


    /** @var array  */
    protected $aliases = [];


    /** @var array  */
    protected $providers = [];


    /** @var array  */
    protected $provides  = [];



    /**
     * @return Container
     *
     * (! static::$instance)
     * is_null(static::$instance)
    */
    public static function getInstance()
    {
        if(is_null(static::$instance))
        {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * @param $abstract
     * @param $concrete
     * @param bool $singleton
     * @return Container
    */
    public function bind($abstract, $concrete, $singleton = false)
    {
         if(is_null($concrete))
         {
             $concrete = $abstract;
         }

         $this->bindings[$abstract] = compact('concrete', 'singleton');

         return $this;
    }


    /**
     * Bind from configuration
     *
     * @param array $configs
     * @return Container
    */
    public function bindings(array $configs)
    {
        foreach ($configs as $config)
        {
            list($abstract, $concrete, $singleton) = $config;
            $this->bind($abstract, $concrete, $singleton);
        }

        return $this;
    }


    /**
     * Set autowiring status
     *
     * @param bool $status
     * @return $this
    */
    public function autowire(bool $status)
    {
        $this->autowire = $status;

        return $this;
    }


    /**
     * Add Service Provider
     * @param string|ServiceProvider $provider
     * @return Container
     *
     *  Example:
     *  $this->addServiceProvider(new \App\Providers\AppServiceProvider());
     *  $this->addServiceProvider(App\Providers\AppServiceProvider::class);
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function addServiceProvider($provider)
    {
        if(class_exists($provider))
        {
            $provider = $this->resolve($provider);
        }

        if($provider instanceof ServiceProvider)
        {
            $this->runServiceProvider($provider);
        }

        return $this;
    }


    /**
     * @param array $providers
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function addServiceProviders(array $providers)
    {
           if(! $providers) return;

           foreach ($providers as $provider)
           {
               $this->addServiceProvider($provider);
           }
    }


    /**
     * @param ServiceProvider $provider
    */
    public function runServiceProvider(ServiceProvider $provider)
    {
        if(! in_array($provider, $this->providers))
        {
            $provider->setContainer($this);
            $implements = class_implements($provider);

            if(isset($implements[BootableServiceProvider::class]))
            {
                $provider->boot();
            }

            if($provides = $provider->getProvides())
            {
                $this->provides[get_class($provider)] = $provides;
            }

            $provider->register();

            $this->providers[] = $provider;
        }
    }



    /**
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }


    /**
     * @param string $providerClass
     * @return array
     */
    public function getProvides($providerClass = '')
    {
        return $this->provides[$providerClass] ?? $this->provides;
    }


    /**
     * Set instance
     *
     * @param $abstract
     * @param $instance
    */
    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }


    /**
     * @return array
    */
    public function getInstances()
    {
        return $this->instances;
    }


    /**
     * Determine if has alias
     *
     * @param $alias
     * @return bool
    */
    public function hasAlias($alias)
    {
        return \array_key_exists($alias, $this->aliases);
    }


    /**
     * @param $alias
     * @return bool|mixed
    */
    public function getAlias($alias)
    {
        if(! $this->hasAlias($alias))
        {
            return false;
        }

        return $this->aliases[$alias];
    }


    /**
     * Singleton
     *
     * @param $abstract
     * @param $concrete
    */
    public function singleton($abstract, $concrete)
    {
        $this->bind($abstract, $concrete, true);
    }


    /**
     * Determine if given abstract is singleton
     * @param $abstract
     * @return bool
    */
    public function isSingleton($abstract)
    {
        return (isset($this->bindings[$abstract]['singleton'])
            && $this->bindings[$abstract]['singleton'] === true);
    }


    /**
     * @param $abstract
     * @param $concrete
     * @return mixed
    */
    protected function getSingleton($abstract, $concrete)
    {
        if(! isset($this->instances[$abstract]))
        {
            $this->instances[$abstract] = $concrete;
        }

        return $this->instances[$abstract];
    }


    /**
     * Create new instance of object wit given params
     *
     * @param $abstract
     * @param array $parameters
     * @return object
     * @throws ReflectionException
    */
    public function make($abstract, $parameters = [])
    {
         return $this->resolve($abstract, $parameters);
    }


    /**
     * Factory
     *
     * @param $abstract
     * @return object
     * @throws ReflectionException
    */
    public function factory($abstract)
    {
        return $this->make($abstract);
    }



    /**
     * Determine if the given id has binded
     *
     * @param $id
     * @return bool
    */
    public function has($id)
    {
        // is binded ?
        if($this->bounded($id))
        {
            return true;
        }

        // is alias ?
        if($this->hasAlias($id))
        {
            return true;
        }

        return false;
    }


    /**
     * Determine if id bounded
     * @param $id
     * @return bool
    */
    public function bounded($id)
    {
        return isset($this->bindings[$id]);
    }


    /**
     * Get value given abstract key
     *
     * @param $abstract
     * @param array $arguments
     * @return object
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
     */
    public function get($abstract, $arguments = [])
    {
           if(! $this->has($abstract))
           {
               if(! $this->autowire)
               {
                    throw new ResolverDependencyException('Cannot do autowiring dependendies');
               }

               return $this->resolve($abstract, $arguments);
           }

           /*
           if(isset($this->instances[$abstract]))
           {
               return $this->instances[$abstract];
           }
           */

           // Get concrete
           $concrete = $this->getConcrete($abstract);

           if($this->isSingleton($abstract))
           {
               return $this->getSingleton($abstract, $concrete);
           }

           return $concrete;
    }


    /**
     * @param $abstract
     * @return mixed
     * @throws InstanceException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function getConcrete($abstract)
    {
        $concrete = $this->bindings[$abstract]['concrete'] ?? null;

        if($concrete instanceof Closure)
        {
            return $concrete($this);
        }

        if(class_exists($concrete))
        {
            return $this->resolve($concrete);
        }

        return $concrete;
    }


    /**
     * Resolve dependency
     *
     * @param $abstract
     * @param array $arguments
     * @return object
     * @throws ReflectionException|InstanceException|ResolverDependencyException
     */
    public function resolve($abstract, array $arguments = [])
    {
          $reflectedClass = new ReflectionClass($abstract);

          if(! $reflectedClass->isInstantiable())
          {
              throw new InstanceException(sprintf('Class [%s] is not instantiable dependency.', $abstract));
          }

          if(! $constructor = $reflectedClass->getConstructor())
          {
                return $this->instances[$abstract] = $reflectedClass->newInstance();
          }

          $dependencies = $this->getDependencies($constructor, $arguments);
          return $this->instances[$abstract] = $reflectedClass->newInstanceArgs($dependencies);
    }


    /**
     * Resolve method dependencies
     *
     * @param \ReflectionMethod $reflectionMethod
     * @param array $arguments
     * @return array
     * @throws ReflectionException|InstanceException|ResolverDependencyException
    */
    public function getDependencies(\ReflectionMethod $reflectionMethod, $arguments = [])
    {
        $dependencies = [];

        foreach ($reflectionMethod->getParameters() as $parameter)
        {
            $dependency = $parameter->getClass();

            if($parameter->isOptional()) { continue; }
            if($parameter->isArray()) { continue; }

            if(is_null($dependency))
            {
                if($parameter->isDefaultValueAvailable())
                {
                    $dependencies[] = $parameter->getDefaultValue();
                }else{

                    if(array_key_exists($parameter->getName(), $arguments))
                    {
                        $dependencies[] = $arguments[$parameter->getName()];
                    }else {
                        $dependencies = array_merge($dependencies, array_values($arguments));
                    }
                }

            } else{

                $dependencies[] = $this->get($dependency->getName());
            }
        }

        return $dependencies;
    }




    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }



    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }



    /**
     * @param mixed $offset
     * @param mixed $value
   */
    public function offsetSet($offset, $value)
    {
        $this->bind($offset, $value);
    }


    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        unset($this->bindings[$offset]);
    }
}