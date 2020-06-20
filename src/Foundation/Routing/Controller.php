<?php
namespace Jan\Foundation\Routing;


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
     * @var ContainerInterface
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
     * @param ContainerInterface $container
     * @param View|null $view
    */
    public function __construct(ContainerInterface $container, View $view = null)
    {
          $this->container = $container;
          $this->view = $view ?? $container->get(View::class);
    }


    /**
     * @param string $template
     * @param array $data
     * @return Response
     * @throws ViewException
    */
    public function render(string $template, array $data = []): Response
    {
         $response = $this->container->get(ResponseInterface::class);
         $content = $this->renderTemplate($template, $data);

         ob_start();
         if($this->layout !== false)
         {
              require $this->view->resource('layouts/'. $this->layout .'.php');
             $content = ob_get_clean();
         }

         $response->withBody($content);

         return $response;
    }


    /**
     * @param string $template
     * @param array $data
     * @return false|string
     * @throws ViewException
     */
    public function renderTemplate(string $template, array $data)
    {
          return $this->view->render($template, $data);
    }


    /**
     * @param array $data
     * @param int $status
     * @return
     */
    public function renderJson(array $data, int $status = 200)
    {
        $response = $this->container->get(ResponseInterface::class);
        return $response->withStatus($status)->withJson($data);
    }



    public function core()
    {
        return [

        ];
    }
}