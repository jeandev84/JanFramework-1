<?php
namespace Jan\Component\Routing\Contracts;


/**
 * Interface RouterInterface
 * @package Jan\Component\Routing\Contracts
*/
interface RouterInterface
{


    /**
     * Get current route
     *
     * @return mixed
    */
    public function getRoute();


    /**
     * Get all routes
     *
     * @return array
    */
    public function getRoutes();



    /**
     * Determine if current route path match URI
     *
     * @param string $requestMethod
     * @param string $requestUri
     * @return mixed
    */
    public function match(string $requestMethod, string $requestUri);



    /**
     * Generate URL
     *
     * @param string $context
     * @param array $params
     * @return mixed
    */
    public function generate(string $context, array $params = []);
}