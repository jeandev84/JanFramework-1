<?php
namespace Jan\Component\Routing;


use Jan\Component\Routing\Exception\RouteException;
use RuntimeException;



/**
 * Class Route
 * @package Jan\Component\Routing
*/
class Route implements \ArrayAccess
{

     /**
      * @var array
     */
     private $methods = [];


     /**
      * @var string
     */
     private $path;



     /**
      * @var array
     */
     private $regex = [];


     /**
      * @var mixed
     */
     private $target;


     /**
      * @var string
     */
     private $name;



     /**
      * @var array
     */
     private $matches = [];



     /**
      * @var array
     */
     private $middleware = [];



     /**
      * @var array
     */
     private $options = [];


    /**
     * @var array
     */
     private $formatParams = [];


     /**
      * @var array
     */
     private $defaultRegex = [];


     /**
      * Route constructor.
      *
      * @param array $methods
      * @param string $path
      * @param null $target
      * @param array $options
     */
     public function __construct(array $methods = [], string $path = '', $target = null, array $options = [])
     {
         $this->setMethods($methods);
         $this->setPath($path);
         $this->setTarget($target);
         $this->setOptions($options);
     }



     /**
     * @return array
    */
    public function getMethods(): array
    {
        return $this->methods;
    }



    /**
     * @param $methods
     * @return Route
    */
    public function setMethods(array $methods): Route
    {
        $this->methods = $methods;
        return $this;
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
    public function getPattern()
    {
        return '#^' . $this->compile(trim($this->getPath(), '/')) . '$#';
    }


    /**
     * @param string $path
     * @return string
    */
    private function compile(string $path)
    {
        return preg_replace_callback($this->getFormatParams(), [$this, 'generateRegex'], $path);
    }


    /**
     * @param array $matches
     * @return array
    */
    public function getFilteredMatchParams(array $matches)
    {
        return array_filter($matches, function ($key) {

            return ! is_numeric($key);

        }, ARRAY_FILTER_USE_KEY);
    }



    /**
     * @param array $matches
     * @return string
    */
    public function generateRegex(array $matches)
    {
        if($this->hasRegex($matches[1]))
        {
            return '(?P<'. $matches[1] .'>'. $this->getRegex($matches[1]) . ')';
        }

        return '([^/]+)';
    }


    /**
     * @param $name
     * @return bool
    */
    public function hasRegex($name)
    {
        return \array_key_exists($name, $this->getAvailableRegex());
    }


    /**
     * @param string|null $name
     * @return string|array
    */
    public function getRegex(string $name)
    {
        $regex = $this->getAvailableRegex();

        return $regex[$name] ?? '';
    }


    /**
     * @return array
    */
    public function getAvailableRegex()
    {
        return array_merge($this->defaultRegex, $this->regex);
    }


    /**
     * @return string[]
    */
    public function getDefaultRegex()
    {
        return $this->defaultRegex;
    }


    /**
     * @param array $defaultRegex
    */
    public function setDefaultRegex(array $defaultRegex)
    {
        $this->defaultRegex = $defaultRegex;
    }


    /**
     * @param $name
     * @param $expression
     * @return Route
    */
    public function setRegex($name, $expression): Route
    {
        $this->regex[$name] = str_replace( '(', '(?:', $expression);
        return $this;
    }


    /**
     * @return array
    */
    public function getFormatParams(): array
    {
        return $this->formatParams;
    }


    /**
     * @param array $formats
     * @return Route
     */
    public function setFormatParams(array $formats): Route
    {
        $formatParams = [];

        foreach ($formats as $format)
        {
            $formatParams[] = '#'. $format . '#';
        }

        $this->formatParams = $formatParams;
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
    public function getMiddleware(): array
    {
        return $this->middleware[$this->path] ?? [];
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



    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }



    /**
     * @param array $options
     * @return Route
    */
    public function setOptions(array $options): Route
    {
        $this->options = $options;
        return $this;
    }


    /**
     * @param string $requestMethod
     * @return bool
     * @throws RouteException
    */
    public function isMatchingMethod(string $requestMethod)
    {
         if(! \in_array($requestMethod, $this->methods))
         {
              throw new RouteException(
                  sprintf('Method %s is not allowed method for current route', $requestMethod)
              );
         }

         return true;
    }


    /**
     * @param string $requestUri
     * @return bool
    */
    public function isMatchingPath(string $requestUri)
    {
        if(preg_match($this->getPattern(), $this->resolveUrl($requestUri), $matches))
        {
            $this->setMatches(
                $this->getFilteredMatchParams($matches)
            );

            return true;
        }

        return false;
    }



    /**
     * @param string $url
     * @return string
    */
    public function resolveUrl(string $url)
    {
        return trim(parse_url($url, PHP_URL_PATH), '/');
    }



    /**
     * @param $requestMethod
     * @param $requestUri
     * @return bool
     * @throws RouteException
   */
    public function match($requestMethod, $requestUri)
    {
        return $this->isMatchingMethod($requestMethod)  && $this->isMatchingPath($requestUri);
    }


    /**
     * @param $name
     * @return string|string[]
    */
//    private function resolveRegex($name)
//    {
//        $regex = array_merge(self::DEFAULT_REGEX_EXPRESSION, $this->regex);
//        return str_replace( '(', '(?:', $regex[$name]);
//    }


    /**
     * @param $name
     * @param $value
    */
    public function set($name, $value)
    {
        if($this->has($name))
        {
             $this->{$name} = $value;
        }
    }



    /**
     * @param $name
     * @return bool
    */
    public function has($name)
    {
        return property_exists($this, $name);
    }


    /**
     * @param $name
     * @return
    */
    public function get($name)
    {
         if($this->has($name))
         {
             return $this->{$name};
         }
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
     * @return mixed|void
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
        $this->set($offset, $value);
    }


    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        if($this->has($offset))
        {
            unset($this->{$offset});
        }
    }
}