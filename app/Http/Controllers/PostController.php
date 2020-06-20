<?php
namespace App\Http\Controllers;


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
 */
    public function __construct(RequestInterface $request)
    {
        // dump($request);
    }


    /**
     * action index
     * @param Request $request
     * @param Response $response
     * @param int|null $id
     * @param string $slug
     */
     public function show(Request $request, Response $response, $id, $slug)
     {

          echo 'ID : '. $id .'<br>';
          echo 'SLUG : '. $slug .'<br>';
          echo __METHOD__;
          dump($response);
          dump($request);
     }
}