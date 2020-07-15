<?php
namespace Jan\Component\DI\Reviews;


use Jan\Component\DI\Exceptions\ContainerException;

/**
 * Class ResolveClassDependencies
 * @package Jan\Component\DI\Reviews
*/
class ResolveClassDependencies
{


    /**
     * @param ReflectionClass $reflectionClass
     * @return array|mixed|object|null
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ResolverDependencyException
     */
    public function resolveClassDependencies(ReflectionClass $reflectionClass)
    {
        /*
        $classname = $reflectionClass->getName();

        if($this->has($classname))
        {
            return $this->get($classname);
        }

        $interfaces = $reflectionClass->getInterfaces();

        foreach ($interfaces as $interface)
        {
            if($dependency = $this->resolveClassDependencies($interface))
            {
                 $dependencies[] = $dependency;
                // return $dependency;
            }
        }

        if($parentClass = $reflectionClass->getParentClass())
        {
            $dependencies[] = $this->resolveClassDependencies($parentClass);
            return $this->resolveClassDependencies($parentClass);
        }
        */
        /* return $dependencies; */

    }

    /*
      private function resolving(ReflectionClass $reflectionClass)
    {
        $interfaces = $reflectionClass->getInterfaces();

        foreach ($interfaces as $interface)
        {
            $name = $interface->getName();
            if(! $this->bounded($name))
            {
                dd($name);
            }
        }
    }

    */
}