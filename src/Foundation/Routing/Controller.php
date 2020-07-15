<?php
namespace Jan\Foundation\Routing;


use Jan\Component\DI\Container;
use Jan\Component\DI\Contracts\ContainerInterface;
use Jan\Component\DI\Exceptions\ContainerException;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Http\Response;
use Jan\Component\Templating\Exceptions\ViewException;
use Jan\Component\Templating\View;


/**
 * Class Controller
 * @package Jan\Foundation\Routing
*/
abstract class Controller
{

    use ControllerTrait;


    /**
     * @return array
    */
    public function coreAliases()
    {
        return [
            //
        ];
    }
}