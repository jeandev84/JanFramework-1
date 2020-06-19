<?php
namespace Jan;


/**
 * Class Kernel
 * @package Jan
*/
class Kernel
{

    /**
     * @var string
    */
    private $baseUrl;


    /**
     * Kernel constructor.
     * @param string $baseUrl
    */
    public function __construct(string $baseUrl)
    {
         $this->baseUrl = rtrim($baseUrl, '/');
    }


    /**
     * Run kernel handle
    */
    public function handle()
    {
        require_once $this->baseUrl .'/routes/web.php';

        # Route Dispatcher
        try {

            $request = \Jan\Component\Http\Request::fromGlobals();

            $dispatcher = new \Jan\Foundation\RouteDispatcher($request);
            $dispatcher->setBaseUrl('http://localhost:8080');
            $dispatcher->setControllerNamespace('App\\Http\\Controllers');
            $response = $dispatcher->callAction();

        } catch (\Exception $e) {

            exit('404 Page not found');
        }
    }
}