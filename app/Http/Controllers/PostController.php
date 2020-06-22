<?php
namespace App\Http\Controllers;


use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;


/**
 * Class PostController
 * @package App\Http\Controllers
*/
class PostController
{

    /**
     * PostController constructor.
     * @param RequestInterface $request
     * @param ContainerInterface $container
     */
    public function __construct(RequestInterface $request, ContainerInterface $container)
    {
        // dump($request->getFiles());
    }


    /**
      * action index
      * @param Request $request
      * @param Response $response
      * @param int|null $id
      * @param string $slug
      * @return Response
     */
     public function show(Request $request, Response $response, $id, $slug)
     {
          return new Response('Show post with id : ' . $id . ' and slud : '. $slug, 200);
     }
}