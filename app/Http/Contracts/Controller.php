<?php
namespace App\Http\Contracts;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Foundation\Routing\Controller as BaseController;


/**
 * Class Controller
 * @package App\Http\Contracts
*/
class Controller extends BaseController
{

     /**
      * @var string
     */
     protected $layout = 'default';


     /**
      * Controller constructor.
      * @param ContainerInterface $container
     */
     public function __construct(ContainerInterface $container)
     {
         parent::__construct($container);
     }
}