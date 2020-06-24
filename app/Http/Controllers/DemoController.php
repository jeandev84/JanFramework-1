<?php
namespace App\Http\Controllers;


use App\Http\Contracts\Controller;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\FileSystem\FileSystem;


/**
 * Class DemoController
 * @package App\Http\Controllers
*/
class DemoController extends Controller
{

      /**
       * @param ContainerInterface $container
       * @return \Jan\Component\Http\Response
       * @throws \Jan\Component\DI\Exceptions\InstanceException
       * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
       * @throws \ReflectionException
      */
      public function index(ContainerInterface $container)
      {
          $fileSystem = new FileSystem($container->get('base.path'));

          echo $fileSystem->resource('config/app.php');
          $config = $fileSystem->load('config/app.php');


          return $this->render('demo/index');
      }
}