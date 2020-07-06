<?php
namespace Jan\Component\Database\Table;


/**
 * Class BluePrint
 * @package Jan\Component\Database\Table
*/
class BluePrint
{

   /** @var string */
   private $table;


   /** @var bool  */
   private $primary = '';


   /** @var array  */
   private $columns = [];


   /**
     * BluePrint constructor.
     * @param string $table
   */
   public function __construct(string $table)
   {
         $this->table = $table;
   }


    /**
     * @param $name
     * @param $type
     * @param int $length
     * @param null $default
     * @param bool $autoincrement
     * @return Column
     * @throws \Exception
   */
   public function addColumn($name, $type, $length = 11, $default = null, $autoincrement = false)
   {
       $type = strtoupper($type);

       $column = new Column(
           compact('name', 'type', 'length', 'default', 'autoincrement')
       );

       if($autoincrement)
       {
           $this->primary = $name;
       }

       return $this->columns[] = $column;
   }


   /**
     * @return bool|string
   */
   public function getPrimary()
   {
       return $this->primary;
   }


   /**
     * @param $name
     * @return Column
     * @throws \Exception
   */
   public function increments($name)
   {
       return $this->addColumn($name, 'INT', 11, null, true);
   }


   /**
     * @param $name
     * @param int $length
     * @return Column
     * @throws \Exception
   */
   public function integer($name, $length = 11)
   {
       return $this->addColumn($name, 'INT', $length);
   }


   /**
     * @param $name
     * @param int $length
     * @return Column
     * @throws \Exception
   */
   public function string($name, $length = 255)
   {
       return $this->addColumn($name, 'VARCHAR', $length);
   }


   /**
     * @param $name
     * @return Column
     * @throws \Exception
   */
   public function boolean($name)
   {
       return $this->addColumn($name, 'TINYINT', 1, 0);
   }


   /**
     * @param $name
     * @return Column
     * @throws \Exception
   */
   public function text($name)
   {
       return $this->addColumn($name, 'TEXT', false);
   }


   /**
     * @param $name
     * @return Column
     * @throws \Exception
   */
   public function datetime($name)
   {
       return $this->addColumn($name, 'DATETIME', false);
   }


   /**
     * @return Column
     * @throws \Exception
   */
   public function timestamps()
   {
        $this->datetime('created_at');
        $this->datetime('updated_at');
   }


   /**
     * @return array
   */
   public function columns()
   {
       return $this->columns;
   }


   /**
     * @param bool $status
     * @throws \Exception
   */
   public function softDeletes(bool $status = false)
   {
       if($status)
       {
           $this->boolean('deleted_at');
       }
   }


   /**
    * @return string
   */
   public function buildColumnSql()
   {
      // (name type(length) default, ...., PRIMARY KEY name)
      $sql = [];
      $space = ' ';
      $nbrColumns = $this->getColumnSCount();
      $i = 0;

      foreach ($this->columns as $column)
      {
          $sql[] = $column->getName(). $space;
          $sql[] = $column->getType(). $space;
          $sql[] = $column->getDefault();
          ++$i;

          if($i < $nbrColumns)
          {
              $sql[] = ', ';
          }
      }

      if($primaryKey = $this->getPrimary())
      {
           $sql[] = sprintf(', PRIMARY KEY(`%s`)', $primaryKey);
      }

      return  implode($sql);
   }


   /**
     * @return int
   */
   public function getColumnSCount()
   {
       return count($this->columns);
   }
}