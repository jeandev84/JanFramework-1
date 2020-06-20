<?php
use Jan\Component\Routing\Route;



if(! function_exists('route'))
{

    /**
     * @param $name
     * @param array $params
     * @return
    */
    function route($name, $params = [])
    {
        return Route::instance()->generate($name, $params);
    }
}