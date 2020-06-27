<?php
namespace Jan\Foundation;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\ContainerException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Foundation\Routing\Controller;
use ReflectionException;


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
       * @throws ContainerException
       * @throws ReflectionException
       * @throws ResolverDependencyException
      */
      public function __construct(ContainerInterface $container)
      {
          parent::__construct($container);
          $this->container->get('view')->setBasePath(__DIR__ . '/Resources/views/');
      }


     /**
       * @return false|string
       * @throws ContainerException
       * @throws ResolverDependencyException
       * @throws ReflectionException
      */
      public function welcome()
      {
           return $this->render('welcome');
      }
}