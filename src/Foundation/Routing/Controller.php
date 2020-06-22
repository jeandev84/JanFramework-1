<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\InstanceException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
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

    /* use ControllerTrait; */


    /**
     * @var string
    */
    protected $layout = 'default';



    /**
     * @var Container
     */
    protected $container;


    /**
     * @param ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return Container
    */
    public function getContainer()
    {
        return $this->container;
    }


    /**
     * @param string $template
     * @param array $data
     * @param Response|null $response
     * @return Response
     * @throws InstanceException
     * @throws ResolverDependencyException
     * @throws \ReflectionException
    */
    public function render(string $template, array $data = [], Response $response = null): Response
    {
         $view = $this->container->get('view');
         $content = $this->renderTemplate($template.'.php', $data);

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
     * @throws InstanceException
     * @throws ResolverDependencyException
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


    /**
     * @return array
    */
    public function coreAliases()
    {
        return [

        ];
    }
}