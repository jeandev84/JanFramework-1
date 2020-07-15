<?php
namespace Jan\Foundation;


use Closure;
use Exception;
use Jan\Component\DI\Container;
use Jan\Component\DI\Exceptions\ResolverDependencyException;
use Jan\Component\Http\Contracts\RequestInterface;
use Jan\Component\Http\Contracts\ResponseInterface;
use Jan\Component\Routing\Exception\RouterException;
use Jan\Component\Routing\Route;
use Jan\Foundation\Exceptions\NotFoundHttpException;
use Jan\Foundation\Providers\ConfigServiceProvider;
use ReflectionException;


/**
 * Class Application
 * @package Jan\Foundation
 *
 * Application  :  JFramework
 * Author       :  Jean-Claude <jeanyao@mail.com>
*/
class Application extends Container
{

    /**
     * The Jan framework version.
     */
    const VERSION = '1.0.0';


    /**
     * The base path for Jan installation
     *
     * @var string
     */
    protected $basePath;



    /** @var array  */
    protected $namespaces = [];



    /**
     * Create a new application instance.
     *
     * Application constructor.
     * @param string $basePath
     * @return void
     * @throws ReflectionException
    */
    public function __construct(string $basePath = null)
    {
        $this->controlPhpVersion();

        if ($basePath) {
            $this->setBasePath($basePath);
        }

        // $this->loadCoreAliases();
        $this->registerCoreAliases();
        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
    }


    // TODO Refactoring
    private function controlPhpVersion()
    {
        if(! version_compare(PHP_VERSION, '7.1.0', '>='))
        {
            exit(
                "This Application use version more or equals to <b>7.1.0</b> or your PHP version is <strong>"
                . PHP_VERSION ."</strong>! Please change your version.."
            );
        }
    }


    /**
     * Get the version number of application.
     *
     * @return string
    */
    public function version()
    {
        return self::VERSION;
    }


    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     * @return $this
    */
    public function setBasePath(string $basePath)
    {
        if ($basePath) {
            $this->basePath = rtrim($basePath, '\/');
        }

        $this->bindPathsInContainer();
        return $this;
    }


    /**
     * Bind all of the application paths in the container
     *
     * @return void
    */
    protected function bindPathsInContainer()
    {
        $this->bind('base.path', $this->basePath);
    }


    /**
     * Register the basic info the container.
     *
     * @return void
    */
    protected function registerBaseBindings()
    {
         $this->instance('app', $this);
         $this->instance(Container::class, $this);
    }


    /**
     * Register all of the base service providers
     *
     * @return void
     * @throws ReflectionException
    */
    protected function registerBaseServiceProviders()
    {
         $this->addServiceProviders($this->getBaseProviders());
    }


    /**
     * Register the core class aliases int the container
     *
     * @return void
    */
    protected function registerCoreAliases()
    {
        /*
        if($aliases = $this->coreAliases())
        {
            foreach ($aliases as $alias => $original)
            {
                $this->setAlias($alias, $original);
            }
        }
        */
    }



    /**
     * @return array
     */
    private function getBaseProviders()
    {
        return [
            'Jan\Foundation\Providers\AppServiceProvider',
            'Jan\Foundation\Providers\FileSystemServiceProvider',
            'Jan\Foundation\Providers\ConfigServiceProvider',
            'Jan\Foundation\Providers\LoaderServiceProvider',
            'Jan\Foundation\Providers\RouteServiceProvider',
            'Jan\Foundation\Providers\DatabaseServiceProvider',
            //'Jan\Foundation\Providers\MiddlewareServiceProvider',
            //'Jan\Foundation\Providers\ConsoleServiceProvider',
            'Jan\Foundation\Providers\ViewServiceProvider'
        ];
    }



    /**
     * @return array
    */
    private function coreAliases()
    {
        //
    }
}