<?php
namespace Jan\Component\Database\Table;


use Exception;
use Jan\Component\Database\Exceptions\TableException;

/**
 * Class Column
 * @package Jan\Component\Database\Table
*/
class Column
{
      const TYPES = [
          'INTEGER',
          'VARCHAR',
          'TEXT',
          'TINYINT',
          'DATETIME'
      ];


      /**
       * Column params
       * @var array
      */
      private $params = [
          'name'          => '',
          'type'          => '',
          'length'        => '',
          'default'       => '',
          'comments'      => [],
          'nullable'      => false,
          'autoincrement' => false,
          //'index'         => 'primary',
          //'collation'     => 'utf8_general_ci'
      ];


      /**
        * Column constructor.
        *
        * @param array $params
        * @throws Exception
      */
      public function __construct($params)
      {
           $this->setParams($params);
      }


      /**
       * @param array $params
       * @throws Exception
      */
      public function setParams(array $params)
      {
          foreach ($params as $key => $value)
          {
              $this->setParam($key, $value);
          }
      }


     /**
       * @param $key
       * @param $value
       * @return Column
       * @throws TableException
      */
      public function setParam($key, $value)
      {
          if(! \array_key_exists($key, $this->params))
          {
              throw new TableException(
                  sprintf('Param (%s) is not valid column param', $key)
              );
          }

          $this->params[$key] = $value;

          return $this;
      }


      /**
       * @param $key
       * @return mixed|null
      */
      private function getParam($key)
      {
          return $this->params[$key] ?? null;
      }



      /**
       * Set nullable column
       *
       * @return $this
       * @throws TableException
      */
      public function nullable()
      {
          return $this->setParam('nullable', true);
      }


    /**
     * Add Interclassment
     * If $this->collation('utf8_unicode'),
     *
     * @param string $collation
     * @return self
     * @throws TableException
    */
    public function collation($collation)
    {
        return $this->setParam('collation', $collation);
    }


    /**
     * @param string|array $comment
     * @return Column
     * @throws TableException
    */
    public function comments($comment)
    {
        $comment = is_array($comment) ? join(', ', $comment) : $comment;
        return $this->setParam('comments', $comment);
    }


    /**
     * Get column name
     *
     * @return string
    */
    public function getName()
    {
        return $this->getParam('name');
    }


    /**
     * Get column type
     *
     * @return string
     *
     * TYPE(LENGTH)
    */
    public function getType()
    {
        $type = $this->getParam('type');

        if(in_array($type, self::TYPES))
        {
             return sprintf('%s(%s)', $type, $this->getParam('length'));
        }
    }


    /**
     * @return string
    */
    public function getDefault()
    {
        $default = $this->getParam('default');

        if($this->isNullable() && ! $default)
        {
            return 'DEFAULT NULL';
        }

        if($default)
        {
            return sprintf('DEFAULT "%s"', $default);
        }

        return 'NOT NULL';
    }


    /**
     * @return bool
    */
    public function isNullable()
    {
        return $this->getParam('nullable') === true;
    }
}