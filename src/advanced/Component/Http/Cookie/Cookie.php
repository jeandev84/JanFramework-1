<?php
namespace Jan\Component\Http\Cookie;


/**
 * Class Cookie
 * @package Jan\Component\Http\Cookie
*/
class Cookie
{

    /**
     * @var array
    */
    protected $cookies;


    /**
     * Cookie constructor.
     * @param array $cookies
    */
    public function __construct(array $cookies = [])
    {
        $this->cookies = $cookies ?? $_COOKIE;
    }


    /**
     * @param $name
     * @param $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $httpOnly
     * @param bool $issecure
    */
    public function set($name, $value, $expire = 3600, $path = '/', $domain = '', $httpOnly = false, $secure = true)
    {
        // setcookie($name, $value, $expire, $path, $domain, $httpOnly, $secure);
    }

}