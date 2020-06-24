<?php
namespace Jan\Foundation;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Templating\View;
use Jan\Foundation\Routing\Controller;


/**
 * Class DefaultController
 * @package Jan\Foundation
*/
class DefaultController extends Controller
{

      /**
       * @var bool
      */
      protected $layout = false;


      /**
       * DefaultController constructor.
       * @param ContainerInterface $container
      */
      public function __construct(ContainerInterface $container)
      {
          parent::__construct($container);
          $container->get('view')->setBasePath(__DIR__ . '/Resources/views/');
      }


     /**
       * @return false|string
       * @throws \Jan\Component\DI\Exceptions\InstanceException
       * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
       * @throws \ReflectionException
      */
      public function welcome()
      {
           return $this->container->get('view')->render('welcome.php');
      }
}