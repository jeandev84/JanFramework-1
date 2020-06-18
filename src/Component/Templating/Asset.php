<?php
namespace Jan\Component\Templating;


/**
 * Class Asset
 * @package Jan\Component\Templating
*/
class Asset
{

     const CSS_BLANK = '<link href="%s" rel="stylesheet">';
     const JS_BLANK  = '<script src="%s" type="application/javascript"></script>';


     /**
      * @var self
     */
     private static $instance;


     /**
      * @var  string
     */
     private static $baseUrl;


     /**
      * @var array
     */
     private static $css = [];



     /**
      * @var array
     */
     private static $js = [];



     /**
      * Get instance of Asset
      *
      * @return Asset
     */
     public static function instance()
     {
           if(! self::$instance)
           {
               self::$instance = new self();
           }

           return self::$instance;
     }


     /**
      * Set base url
      *
      * @param string $baseUrl
      * @return Asset
     */
     public function setBaseUrl(string $baseUrl)
     {
          self::$baseUrl = rtrim(self::$baseUrl, '/');

          return $this;
     }


     /**
      * @param array $links
      * @return Asset
     */
     public function setLinks(array $links)
     {
          self::$css = array_merge(self::$css, $links);

          return $this;
     }


    /**
     * @param array $scripts
     * @return Asset
    */
    public function setScripts(array $scripts)
    {
        self::$js = array_merge(self::$js, $scripts);

        return $this;
    }


     /**
      * Add css link
      *
      * @param string $link
     */
     public static function css(string $link)
     {
          self::$css[] = $link;
     }


     /**
       * Add js link
       *
       * @param string $js
     */
     public static function js(string $js)
     {
          self::$js[] = $js;
     }


     /**
      * @return string
     */
     public static function renderCss()
     {
          $html = '';
          foreach (self::$css as $link)
          {
              $html .= sprintf(self::CSS_BLANK, self::$baseUrl . "/$link");
              $html .= "\n";
          }
          return $html;
     }


    /**
     * @return string
    */
    public static function renderJs()
    {
        $html = '';
        foreach (self::$js as $script)
        {
            $html .= sprintf(self::JS_BLANK, self::$baseUrl . "/$script");
            $html .= "\n";
        }
        return $html;
    }
}