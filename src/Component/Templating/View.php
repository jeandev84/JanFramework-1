<?php
namespace Jan\Component\Templating;


use Jan\Component\Templating\Exceptions\ViewException;


/**
 * Class View
 * @package Jan\Component\Templating
*/
class View
{


      /** @var string */
      protected $basePath;


      /** @var string */
      protected $template;


      /** @var array */
      protected $data = [];


      /**
       * @var array
      */
      protected $extensions = [];



      /**
       * View constructor.
       * @param string $basePath
      */
      public function __construct(string $basePath)
      {
           $this->setBasePath($basePath);
      }


      /**
       * @param string $basePath
       * @return $this
      */
      public function setBasePath(string $basePath)
      {
          $this->basePath = rtrim($basePath, '/');

          return $this;
      }



      /**
       * Set globals variables
       *
       * @param array $data
       * @return View
      */
      public function setData(array $data)
      {
           $this->data = array_merge($this->data, $data);

           return $this;
      }


      /**
       * @param string $template
       * @return View
      */
      public function setPath(string $template)
      {
          $this->template = $template;

          return $this;
      }



     /**
      * @param ViewExtension $extension
     */
     public function addExtension(ViewExtension $extension)
     {
          $this->extensions[] = $extension;
     }


     /**
       * Render view template and optional data
       * @param string $template
       * @return false|string
       * @throws ViewException
     */
     public function renderTemplate(string $template)
     {
           extract($this->data);
           ob_start();
           require $this->resource($template);
           return ob_get_clean();
     }


      /**
       * Factory render method
       *
       * @param string $template
       * @param array $variables
       * @return false|string
       * @throws ViewException
      */
      public function render(string $template, array $variables = [])
      {
           return $this->setData($variables)->renderTemplate($template);
      }


      /**
       * Get view file resource
       * @param string $path
       * @return string
       * @throws ViewException
      */
      public function resource(string $path)
      {
          $template = $this->generateTemplateFile($path);

          if(! file_exists($template))
          {
              throw new ViewException(
                  sprintf('Can not found view (%s) ', $template),
                  404
              );
          }

          return $template;
      }


      /**
       * @param string $path
       * @return string
      */
      public function generateTemplateFile(string $path)
      {
          return $this->basePath . DIRECTORY_SEPARATOR . ltrim($path, '\/');
      }
}