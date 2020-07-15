<?php
namespace Jan\Foundation\Http;


use App\Entity\User;
use Jan\Component\Http\Response;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\FileSystem\FileSystem;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Contracts\Http\Kernel as HttpKernelContract;
use Jan\Foundation\RouteDispatcher;


/**
 * Class Kernel
 * @package Jan\Foundation\Http
 */
class Kernel implements HttpKernelContract
{

    /**
     * @var string[]
    */
    protected $classAliases = [
        'Route' => 'Jan\\Foundation\Routing\\Route'
    ];


    /**
     * @var array
    */
    protected $middlewarePriority = [
        /*
        \Jan\Component\Session\Middleware\StartSession::class,
        \Jan\Component\View\Middleware\ShareErrorsFromSession::class,
        \Jan\Component\Contracts\Auth\Middleware\AuthenticatesRequests::class,
        \Jan\Component\Routing\Middleware\ThrottleRequests::class,
        \Jan\Component\Session\Middleware\AuthenticateSession::class,
        \Jan\Component\Routing\Middleware\SubstituteBindings::class,
        \Jan\Component\Auth\Middleware\Authorize::class,
        */
    ];



    /** @var array  */
    protected $routeMiddleware = [];



    /** @var ContainerInterface */
    protected $container;


    /**
     * Kernel constructor.
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
          $this->container = $container;
          $this->loadClassAliases();
          $this->loadRoutes();
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
    */
    public function handle(RequestInterface $request): ResponseInterface
    {
        try {

            $response = $this->dispatchRoute($request);

        } catch (\Exception $e) {

            if($e->getCode() == 404)
            {
                exit('404 Page not found');
            }

            exit($e->getMessage());
        }

        return $response;
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed|void
    */
    public function terminate(RequestInterface $request, ResponseInterface $response)
    {
        //
    }


    /**
     * @param RequestInterface $request
     * @return mixed
    */
    protected function dispatchRoute(RequestInterface $request)
    {
         $response = $this->container->get(ResponseInterface::class);
         $dispatcher = $this->container->get(RouteDispatcher::class);
         $dispatcher->middlewareGroup($this->middlewares);
         return $dispatcher->dispatch($request, $response);
    }


    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
    */
    protected function respond($respond)
    {
        if(! $respond instanceof ResponseInterface)
        {
            $response = new Response();

            if(is_array($respond))
            {
                return $response->withJson($respond);
            }

            return $response->withBody($respond);
        }

        return $respond;
    }


    /**
     *  Load environment variables
    */
    public function loadEnvironments()
    {
         //
    }


    /**
     * Load application configuration
    */
    public function loadConfigurations()
    {
          //
    }


    /**
     * Load routes
    */
    public function loadRoutes()
    {
        $this->getFileSystem()->load('/routes/web.php');

        /* require_once $this->container->get('base.path') .'/routes/*.php'; */
        /*  require_once $this->container->get('base.path') .'/routes/web.php'; */
    }


    /**
     * @return mixed
    */
    private function getFileSystem()
    {
        return $this->container->get(FileSystem::class);
    }



    /**
     * Load classe aliases
    */
    public function loadClassAliases()
    {
        foreach ($this->classAliases as $alias => $original)
        {
            class_alias($original, $alias);
        }
    }

}