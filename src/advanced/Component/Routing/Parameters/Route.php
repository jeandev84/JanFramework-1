<?php
namespace Jan\Component\Routing;


/**
 * Class Route
 * @package Jan\Component\Routing
*/
class Route
{

     /** @var string */
     private $path;


     /** @var string */
     private $name;


     /** @var mixed */
     private $target;


     /** @var  */
     private $pattern;


     /** @var array  */
     private $matches = [];


     /** @var array  */
     private $methods = [];


     /** @var array  */
     private $middleware = [];


     /**
      * RouteParam constructor.
      * @param array $params
     */
     public function __construct(array $params = [])
     {
         $this->setParams($params);
     }


     /**
      * @param array $params
     */
     public function setParams(array $params)
     {
         foreach ($params as $key => $value)
         {
             if(property_exists($this, $key))
             {
                 $this->{$key} = $value;
             }
         }
     }


    /**
     * @return string
    */
    public function getPath(): string
    {
        return $this->path;
    }


    /**
     * @param string $path
     * @return Route
    */
    public function setPath(string $path): Route
    {
        $this->path = $path;
        return $this;
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return Route
    */
    public function setName(string $name): Route
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return mixed
    */
    public function getTarget()
    {
        return $this->target;
    }


    /**
     * @param mixed $target
     * @return Route
    */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }


    /**
     * @return mixed
    */
    public function getPattern()
    {
        return $this->pattern;
    }


    /**
     * @param mixed $pattern
     * @return Route
    */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }


    /**
     * @return array
    */
    public function getMatches(): array
    {
        return $this->matches;
    }


    /**
     * @param array $matches
     * @return Route
    */
    public function setMatches(array $matches): Route
    {
        $this->matches = $matches;
        return $this;
    }


    /**
     * @return array
    */
    public function getMethods(): array
    {
        return $this->methods;
    }



    /**
     * @param array $methods
     * @return Route
    */
    public function setMethods(array $methods): Route
    {
        $this->methods = $methods;
        return $this;
    }


    /**
     * @return array
    */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }



    /**
     * @param array $middleware
     * @return Route
    */
    public function setMiddleware(array $middleware): Route
    {
        $this->middleware = $middleware;
        return $this;
    }
}