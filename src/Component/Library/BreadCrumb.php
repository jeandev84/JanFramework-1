<?php
namespace Jan\Component\Library;


/**
 * Class BreadCrumb
 * @package Jan\Component\Library
 */
class BreadCrumb
{

    /**
     * @var array
     */
    private $items = [];


    /**
     * @var string
     */
    protected $separator = ' / ';


    /**
     * @var string
     */
    protected $template;


    /**
     * @var string
     */
    protected $domain = '';


    /**
     * BreadCrumb constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        if($items)
        {
            $this->setItems($items);
        }
    }


    /**
     * @param string $separator
     * @return BreadCrumb
     */
    public function setSeparator(string $separator): BreadCrumb
    {
        $this->separator = $separator;

        return $this;
    }


    /**
     * @param array $items
     * @return BreadCrumb
     */
    public function setItems(array $items): BreadCrumb
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }


    /**
     * @param string $template
     * @return BreadCrumb
     */
    public function setTemplate(string $template): BreadCrumb
    {
        $this->template = $template;

        return $this;
    }


    /**
     * @param string $domain
     * @return BreadCrumb
     */
    public function setDomain(string $domain): BreadCrumb
    {
        $this->domain = $domain;

        return $this;
    }


    /**
     * @param string $title
     * @param string $link
     * @return BreadCrumb
     */
    public function add(string $title, string $link): BreadCrumb
    {
        $this->items[$title] = $link;

        return $this;
    }


    /**
     * @return string
     */
    public function build()
    {
        $count = 0;
        $breadCrumbHtml = '';

        foreach ($this->items as $title => $link)
        {
            $breadCrumbHtml .= $this->renderHtml($this->domain, $title, $link);
            $count++;

            if($count !== count($this->items))
            {
                $breadCrumbHtml .= $this->separator;
            }
        }

        return $breadCrumbHtml;
    }


    /**
     * @param string $domain
     * @param string $title
     * @param string $link
     * @return false|string
     */
    public function renderHtml(string $domain, string $title, string $link)
    {
        ob_start();
        @require $this->template;
        return ob_get_clean();
    }
}
