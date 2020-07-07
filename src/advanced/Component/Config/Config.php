<?php
namespace Jan\Component\Config;


use Jan\Component\Config\Loaders\Contracts\Loader;

/**
 * Class Config
 * @package Jan\Component\Config
*/
class Config
{

    /** @var array  */
    protected $config = [];


    /** @var array  */
    protected $cache = [];


    /**
     * @param array $loaders
     * @return Config
    */
    public function load(array $loaders)
    {
        foreach ($loaders as $loader)
        {
             if(! $loader instanceof Loader)
             {
                 continue;
             }

             $this->config = array_merge($this->config, $loader->parse());
        }

        return $this;
    }


    /**
     * Get item from config or cache by given key
     *
     * @param $key
     * @param null $default
     * @return mixed
     *
     * Example:
     *   (new Config())->get('app')
     *   (new Config())->get('app.name')
     *   (new Config())->get('app.name.short')
     *
     * From container Service Providers
     * dump($container->get('config')->get('app.name.short'));
     */
    public function get($key, $default = null)
    {
         if($this->existsInCache($key))
         {
             return $this->fromCache($key);
         }

         return $this->addToCache($key, $this->extractFromConfig($key) ?? $default);
    }


    /**
     * Extract data from config by given key
     *
     * @param $key
     * @return array|mixed|void
    */
    protected function extractFromConfig($key)
    {
        $filtered = $this->config;

        foreach (explode('.', $key) as $segment)
        {
            if($this->exists($filtered, $segment))
            {
                $filtered = $filtered[$segment];
                continue;
            }

            return;
        }

        return $filtered;
    }


    /**
     * Determine if the given key exist in the cache
     *
     * @param $key
     * @return bool
     */
    protected function existsInCache($key)
    {
        return isset($this->cache[$key]);
    }


    /**
     * Get item from the cache
     *
     * @param $key
     * @return mixed
     */
    protected function fromCache($key)
    {
         return $this->cache[$key];
    }

    /**
     * Add item to the cache
     * @param $key
     * @param $value
     * @return mixed
    */
    protected function addToCache($key, $value)
    {
         $this->cache[$key] = $value;

         return $value;
    }


    /**
     * Determine if the given key $key exist in $config
     *
     * @param array $config
     * @param $key
     * @return bool
    */
    protected function exists(array $config, $key)
    {
         return array_key_exists($key, $config);
    }
}