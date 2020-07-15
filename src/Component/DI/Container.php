<?php
namespace Jan\Component\DI;


use Closure;
use Jan\Component\DI\Contracts\BootableServiceProvider;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\ContainerException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\DI\ServiceProvider\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;


/**
 * Class Container
 * @package Jan\Component\DI
 *
 * TODO Refactoring Container Dependency Injection
*/
class Container implements \ArrayAccess, ContainerInterface
{

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
     * @param mixed $concrete
     * @param bool $singleton
     * @return Container
    */
    public function bind($abstract, $concrete = null, $singleton = false)
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
     * Add Service Provider
     * @param string|ServiceProvider $provider
     * @return Container
     *
     *  Example:
     *  $this->addServiceProvider(new \App\Providers\AppServiceProvider());
     *  $this->addServiceProvider(App\Providers\AppServiceProvider::class);
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function addServiceProvider($provider)
    {
        if(is_string($provider))
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
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function addServiceProviders(array $providers)
    {
           if(! $providers) {

               throw new ContainerException('Empty services providers!');
           }

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
                $this->provides[] = $provides;
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
     * @param object $abstract
     */
    public function setInstance($abstract)
    {
        $this->instances[get_class($abstract)] = $abstract;
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
     * @param $alias
     * @param $original
    */
    public function setAlias($alias, $original)
    {
        $this->aliases[$alias] = $original;
    }



    /**
     * @param array $aliases
    */
    public function setAliases(array $aliases)
    {
        foreach ($aliases as $alias => $original)
        {
             $this->setAlias($alias, $original);
        }
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
        // has binded ?
        if($this->bounded($id))
        {
            return true;
        }

        // has alias ?
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
     * @return mixed
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function get($abstract, $arguments = [])
    {
        if(! $this->has($abstract))
        {
            return $this->resolve($abstract, $arguments);
        }

        return $this->getConcrete($abstract);
    }


    /**
     * @param $abstract
     * @return mixed
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ResolverDependencyException
    */
    public function getConcrete($abstract)
    {
        $concrete = $this->resolvedConcrete($abstract);

        // Get instances
        if(isset($this->instances[$abstract]))
        {
            return $this->instances[$abstract];
        }

        if(isset($this->aliases[$abstract]))
        {
            $abstract = $this->aliases[$abstract];

            if(isset($this->instances[$abstract]))
            {
                return $this->instances[$abstract];
            }

            return $abstract;
        }

        if(is_string($concrete) && class_exists($concrete))
        {
            return $this->resolve($concrete);
        }

        if($this->isSingleton($abstract))
        {
            return $this->getSingleton($abstract, $concrete);
        }

        return $concrete;
    }


    /**
     * @param $abstract
     * @return mixed
    */
    private function resolvedConcrete($abstract)
    {
        $concrete = $this->bindings[$abstract]['concrete'] ?? null;

        if($concrete instanceof Closure)
        {
            return $concrete($this);
        }

        return $concrete;
    }


    /**
     * Resolve dependency
     *
     * @param $abstract
     * @param array $arguments
     * @return object|array
     * @throws ReflectionException|ContainerException|ResolverDependencyException
     *
     * $container = new \Jan\Component\DI\Container();
     * $container->bind(App\Demo\Foo::class);
     * $container->get(App\Demo\Foo::class);
     * $container->get(App\Demo\FooInterface::class);
     * dump($container->get(\App\Demo\Bar::class));
     * dd($container);
     */
    public function resolve($abstract, array $arguments = [])
    {
          $reflectedClass = new ReflectionClass($abstract);

          if(! $reflectedClass->isInstantiable())
          {
              if(! $this->bounded($abstract))
              {
                   return $this->getImplementedClasses($abstract);
              }

              throw new ContainerException(
                  sprintf('Class [%s] is not instantiable dependency.', $abstract)
              );
          }

          return $this->instances[$abstract] = $this->resolveInstance($reflectedClass, $arguments);
    }



    /**
     * @param ReflectionClass $reflectedClass
     * @return object
    */
    private function resolveInstance(ReflectionClass $reflectedClass, $arguments = [])
    {
       if($reflectedClass->isInstantiable())
       {
           if(! $constructor = $reflectedClass->getConstructor())
           {
               return $reflectedClass->newInstance();
           }

           $dependencies = $this->resolveMethodDependencies($constructor, $arguments);
           return $reflectedClass->newInstanceArgs($dependencies);
       }
    }


    /**
     * @param $abstract
     * @return array
    */
    public function getImplementedClasses($abstract)
    {
        $implements = [];
        $classes = get_declared_classes();

        foreach ($classes as $classname)
        {
            if(in_array($abstract, class_implements($classname)))
            {
                $implements[] = $classname;
            }
        }

        foreach ($implements as $classname)
        {
            if(array_key_exists($classname, $this->instances))
            {
                return $this->instances[$classname];
            }
        }
    }


    /**
     * Resolve method dependencies
     *
     * @param ReflectionMethod $reflectionMethod
     * @param array $arguments
     * @return array
     * @throws ReflectionException|ContainerException|ResolverDependencyException
    */
    public function resolveMethodDependencies(ReflectionMethod $reflectionMethod, $arguments = [])
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
                        $dependencies = array_merge($dependencies, $arguments);
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