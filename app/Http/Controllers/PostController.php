<?php
namespace App\Http\Controllers;



/**
 * Class PostController
 * @package App\Http\Controllers
*/
class PostController
{

    /**
     * action index
     * @param int|null $id
     * @param string $slug
     */
     public function show(int $id, string $slug)
     {
          echo 'ID : '. $id .'<br>';
          echo 'SLUG : '. $slug .'<br>';
          echo __METHOD__;
     }
}