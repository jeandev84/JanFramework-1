<?php
namespace Jan\Component\Database\ORM;


use ArrayAccess;
use Exception;
use Jan\Component\Database\Manager;


/**
 * Class ActiveRecord
 * @package Jan\Component\Database\ORM
*/
class ActiveRecord
{

    /**
     * @var array
    */
    protected $attributes = [];


    /**
     * @var array
     */
    protected $fillable = [];


    /**
     * @var string[]
     */
    protected $guarded = ['id'];


    /**
     * @var array
     */
    protected $hidden = ['password'];


    /**
     * @param $column
     * @return bool
     */
    public function hasAttribute($column)
    {
        return isset($this->attributes[$column]);
    }


    /**
     * @param $column
     * @param $value
     */
    public function setAttribute($column, $value)
    {
        $this->attributes[$column] = $value;
    }


    /**
     * @param $column
     * @return mixed|null
     */
    public function getAttribute($column)
    {
        return $this->attributes[$column] ?? null;
    }


    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $column => $value)
        {
            $this->setAttribute($column, $value);
        }
    }


    /**
     * @return mixed|null
    */
    public function getAttributes()
    {
        return $this->attributes;
    }



    /**
     * @param $column
     * @param $value
    */
    public function __set($column, $value)
    {
        $this->setAttribute($column, $value);
    }



    /**
     * @param $column
     * @return mixed|null
    */
    public function __get($column)
    {
        return $this->getAttribute($column);
    }



    /**
     * @return Manager
     * @throws Exception
    */
    public static function findAll()
    {
        return self::query(
            sprintf('SELECT * FROM %s', self::getTable())
        );
    }



    /**
     * @param array $criteria
    */
    public static function findBy(array $criteria = [])
    {
        //
    }


    /**
     * @param array $criteria
    */
    public static function findOne(array $criteria = [])
    {
        //
    }


    /**
     * @param $id
     * @return Manager
     * @throws Exception
    */
    public static function find($id)
    {
        return self::query(
            sprintf('SELECT * FROM %s WHERE id = :id', self::getTable()),
            compact('id')
        );
    }


    /**
     * @param $condition
     * @param $value
     * @return Manager
     * @throws Exception
    */
    public static function where($condition, $value)
    {
        return self::query(
            sprintf('SELECT * FROM %s WHERE %s', self::getTable(), $condition),
            [$value]
        );
    }



    /**
     * Save data to the database
    */
    public function save()
    {
        $columnMap = $this->getColumns();
    }


    /**
     * Get columns
    */
    protected function getColumns()
    {
        return [];
    }


    /**
     * @param $sql
     * @param array $params
     * @return Manager
     * @throws Exception
    */
    protected static function query($sql, $params = [])
    {
        return Manager::query($sql, $params, static::class);
    }


    /**
     * @return string
    */
    protected static function getTable()
    {
        $reflectedClass = new \ReflectionClass(static::class);
        $name = mb_strtolower($reflectedClass->getShortName()).'s';
        return Manager::config('prefix') . $name;
    }
}