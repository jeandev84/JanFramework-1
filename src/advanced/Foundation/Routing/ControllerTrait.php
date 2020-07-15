<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\ContainerException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Response;
use ReflectionException;


/**
 * Trait ControllerTrait
 * @package Jan\Foundation\Routing
*/
trait ControllerTrait
{


    /**
     * @var string
    */
    protected $layout;



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
     * @throws ContainerException
     * @throws ResolverDependencyException
     * @throws ReflectionException
     */
    public function render(string $template, array $data = [], Response $response = null): Response
    {
        $view = $this->container->get('view');
        $content = $this->renderTemplate($template.'.php', $data);

        ob_start();
        if($this->layout !== false)
        {
            require $view->resource(sprintf('layouts/%s.php', $this->layout));
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
     * @throws ContainerException
     * @throws ResolverDependencyException
     * @throws ReflectionException
     */
    public function renderTemplate(string $template, array $data)
    {
        /*
        $templateInfo = pathinfo($template);
        $template = str_replace('.', '/', $templateInfo['filename']);
        $template .= '.'. $templateInfo['extension'];
        */
        $view = $this->container->get('view');
        $view->setData($data);
        return $view->renderTemplate($template);
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
}