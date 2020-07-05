<?php
namespace App\Http;


use Jan\Foundation\Http\Kernel as HttpKernel;
use Jan\Foundation\Middlewares\RouteDispatcher;


/**
 * Class Kernel
 * @package App\Http
*/
class Kernel extends HttpKernel
{
    protected $middlewares = [
        // RouteDispatcher::class
    ];
}