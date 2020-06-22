<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Response;
use Jan\Component\Templating\Exceptions\ViewException;
use Jan\Component\Templating\View;

/**
 * Class Controller
 * @package Jan\Foundation\Routing
*/
abstract class Controller
{

    /**
     * @var Container
    */
    protected $container;


    /**
     * @var string
    */
    protected $layout = 'default';


    /**
     * @var
    */
    protected $view;


    /**
     * Controller constructor.
     *
     * @param Container $container
    */
    public function __construct(Container $container)
    {
         $this->container = $container;
    }


    /**
     * @return Container
    */
    public function getContainer(): Container
    {
        return $this->container;
    }


    /**
     * @param string $template
     * @param array $data
     * @param Response|null $response
     * @return Response
     * @throws ViewException
    */
    public function render(string $template, array $data = [], Response $response = null): Response
    {
         $view = $this->container->get('view');
         $content = $this->renderTemplate($template, $data);

         ob_start();
         if($this->layout !== false)
         {
              require $view->resource('layouts/'. $this->layout .'.php');
              $content = ob_get_clean();
         }

         if(! $response)
         {
             $response = new Response();
         }

         $response->setContent($content);

         return $response;
    }


    /**
     * @param string $template
     * @param array $data
     * @return false|string
     * @throws \Jan\Component\DI\Exceptions\InstanceException
     * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
     * @throws \ReflectionException
    */
    public function renderTemplate(string $template, array $data)
    {
          return $this->container->get('view')->render($template, $data);
    }


    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param Response|null $response
     * @return Response
     */
    public function json(array $data, int $status = 200, array $headers = [], Response $response = null)
    {
         if(! $response)
         {
             $response = new Response();
         }
         $response->setHeaders($headers);
         $response->setStatus($status);
         return $response->withJson($data);
    }



    public function core()
    {
        return [

        ];
    }
}