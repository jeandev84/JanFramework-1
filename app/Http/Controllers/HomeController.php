<?php
namespace App\Http\Controllers;


# use Jan\Component\Database\Database;
use App\Http\Contracts\Controller;
use Jan\Component\DI\Container;
use Jan\Component\DI\Exceptions\ContainerException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Foundation\Services\Upload;


/**
 * Class HomeController
 * @package App\Http\Controllers
*/
class HomeController extends Controller
{

     /**
      * @return Response
      * @throws ContainerException
      * @throws ResolverDependencyException
      * @throws \ReflectionException
      */
      public function index(RequestInterface $request)
      {
           return $this->render('blog/home/index');
      }


    /**
     * @param Request $request
     * @param Upload $uploader
     * @return Response
     * @throws ContainerException
     * @throws ResolverDependencyException
     * @throws \ReflectionException
     */
      public function contact(Request $request, Upload $uploader)
      {
          echo $request->getMethod() . ' ' . $request->getPath();
          // dump($_POST, $_FILES);
          dump($uploadedFiles = $request->file('contact'));

          // Image uploader
          // $uploader->upload($uploadedFiles);

          return $this->render('blog/home/contact');
      }

}