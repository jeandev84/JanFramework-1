<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\DI\Container;
use Jan\Foundation\Exceptions\NotFoundHttpException;



/**
 * Class Application
 * @package Jan\Foundation
 *
 * Application  :  JFramework
 * Author       :  Jean-Claude <jeanyao@mail.com>
*/
final class Application extends Container
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


    /**
     * Create a new application instance.
     *
     * Application constructor.
     * @param string $basePath
     * @return void
     * @throws \ReflectionException
    */
    public function __construct(string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        // $this->registerBaseBindings();
        // $this->registerBaseServiceProviders();
        // $this->registerCoreContainerAliases();
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
     * @return void
    */
    protected function loadHelpers()
    {
        //
    }



    /**
     * Register the basic info the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
         //
    }


    /**
     * Register all of the base service providers
     *
     * @return void
    */
    protected function registerBaseServiceProviders()
    {
         //
    }


    /**
     * Register the core class aliases int the container
     *
     * @return void
     */
    protected function registerCoreContainerAliases()
    {
        //
    }

}