<?php
namespace App\Http\Controllers;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
// use Jan\Foundation\Routing\Controller;
use App\Http\Contracts\Controller;



/**
 * Class PostController
 * @package App\Http\Controllers
*/
class PostController extends Controller
{

    /**
     * PostController constructor.
     * @param ContainerInterface $container
     * @param RequestInterface $request
    */
    public function __construct(ContainerInterface $container, RequestInterface $request)
    {
        // dump($container);
        // dump($request->getFiles());
           parent::__construct($container);
    }


    /**
     * action index
     * @param Container $container
     * @param Request $request
     * @param int|null $id
     * @param string $slug
     * @return Response
     * @throws \Jan\Component\DI\Exceptions\ContainerException
     * @throws \Jan\Component\DI\Exceptions\ResolverDependencyException
     * @throws \ReflectionException
     *
     * URI : post/5/article-4?page=3&sort=asc
     */
     public function show(Container $container, Request $request, $id, $slug): Response
     {
          /* return new Response('Show post with id : ' . $id . ' and slug : '. $slug, 200); */
          return $this->render('blog/posts/index', compact('id', 'slug'));
     }
}