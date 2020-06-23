<?php
namespace App\Http\Controllers;


use App\Http\Contracts\Controller;
use Jan\Component\DI\Container;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Request;


/**
 * Class HomeController
 * @package App\Http\Controllers
*/
class HomeController extends Controller
{

     /**
      * @return \Jan\Component\Http\Response
      * @throws \Jan\Component\DI\Exceptions\InstanceException
      * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
      * @throws \ReflectionException
      */
      public function index(Container $container)
      {
           return $this->render('blog/home/index');
      }


      /**
       * @param Request $request
       * @return \Jan\Component\Http\Response
       * @throws \Jan\Component\DI\Exceptions\InstanceException
       * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
       * @throws \ReflectionException
      */
      public function contact(Request $request)
      {
          echo $request->getMethod() . ' ' . $request->getPath();
          // dump($_POST, $_FILES);
          dump($request->file('contact'));

          return $this->render('blog/home/contact');
      }

}