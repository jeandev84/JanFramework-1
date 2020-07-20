<?php
namespace Jan\Component\Library;


use Jan\Component\DI\Contracts\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;





/**
 * Class BreadCrumbExtension
 * @package Jan\Component\
 */
class BreadCrumbExtension extends AbstractExtension
{

    /** @var ContainerInterface  */
    protected $container;


    /**
     * ProjectTwigExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('breadcrumbs', [$this, 'breadCrumbHtml'])
        ];
    }


    /**
     * @return mixed
     */
    public function breadCrumbHtml()
    {
        return $this->getBreadCrumb()->build();
    }


    /**
     * @return object|null
     */
    private function getBreadCrumb()
    {
        return $this->container->get('breadcrumb');
    }
}