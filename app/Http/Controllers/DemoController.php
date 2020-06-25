<?php
namespace App\Http\Controllers;


use App\Http\Contracts\Controller;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\InstanceException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\FileSystem\Exceptions\FileSystemException;
use Jan\Component\FileSystem\FileSystem;
use ReflectionException;


/**
 * Class DemoController
 * @package App\Http\Controllers
*/
class DemoController extends Controller
{

    /**
     * @param ContainerInterface $container
     * @return \Jan\Component\Http\Response
     * @throws InstanceException
     * @throws ResolverDependencyException
     * @throws ReflectionException
     * @throws FileSystemException
     */
      public function index(ContainerInterface $container)
      {
          $fileSystem = new FileSystem($container->get('base.path'));
          $fileSystem->make('app/Http/Controllers/TestController.php');

          return $this->render('demo/index');
      }
}