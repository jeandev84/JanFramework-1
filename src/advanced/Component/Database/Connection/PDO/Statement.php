<?php
namespace Jan\Component\Database\Connection\PDO;


use Closure;
use Exception;
use PDO;
use PDOException;
use PDOStatement;


/**
 * Class Statement
 * @package Jan\Component\Database\Connection\PDO
*/
class Statement
{

   /**
    * @var PDO
   */
    protected $pdo;



    /**
     * @var PDOStatement
    */
    private $statement;


    /**
     * @var array
     */
    protected $records = [];


    /**
     * @var array
     */
    protected $bindValues = [];


    /**
     * @var string
     */
    protected $classMap;  /* stdClass::class */


    /**
     * @var string
     */
    protected $sql;


    /**
     * @var array
    */
    protected $params = [];


    /**
      * Statement constructor.
      * @param PDO $pdo
    */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @param string $sql
     * @param array $params
     * @param string $classMap
     * @return Statement
    */
    public function query($sql, $params = [], $classMap = null)
    {
        try {

            $this->statement = $this->pdo->prepare($sql);
            $this->sql = $sql;
            $this->params = $params;
            $this->classMap = $classMap;

            if($this->statement->execute($params))
            {
                $this->records[] = compact('sql', 'params');
            }

            /*
            if($params && $this->statement->execute($params))
            {
                $this->records[] = compact('sql', 'params');
            }
            */

        } catch (PDOException $e) {

            throw $e;
        }

        return $this;
    }


    /**
     * @param string $param
     * @param $value
     * @param int $type
     * @return $this
     */
    public function bindValues(string $param, $value, int $type = 0)
    {
        $this->bindValues[] = [$param, $value, $type];
        return $this;
    }



    /**
     * @return $this
     */
    public function execute()
    {
        if($this->bindValues)
        {
            foreach ($this->bindValues as $bindValues)
            {
                list($param, $value, $type) = $bindValues;
                $this->statement->bindValue($param, $value, $type);
            }
        }

        $this->statement->execute();
        return $this;
    }


    /**
     * @return array
    */
    public function getRecords()
    {
        return $this->records;
    }


    /**
     * @throws Exception
    */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }


    /**
     * @throws Exception
    */
    public function rollback()
    {
        $this->pdo->rollBack();
    }


    /**
     * @throws Exception
     */
    public function commit()
    {
        $this->pdo->commit();
    }


    /**
     * @param Closure $callback
     * @throws Exception
   */
    public function transaction(Closure $callback)
    {
        try {

            $this->beginTransaction();
            $callback($this);
            $this->commit();

        } catch (PDOException $e) {

            $this->rollback();
            throw $e;
        }
    }


    /**
     * @param string $sql
     * @throws Exception
     * @return mixed|void
    */
    public function exec(string $sql)
    {
        try {

            if($this->pdo->exec($sql))
            {
                $this->records[] = compact('sql');
            }

        } catch (PDOException $e) {

            throw $e;
        }
    }



    /**
     * @param int|string $fetchStyle
     * @return array
   */
    public function get(string $fetchStyle = PDO::FETCH_OBJ)
    {
        if($this->classMap)
        {
            return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->classMap);
        }

        return $this->statement->fetchAll($fetchStyle);
    }


    /**
     * Get first result
    */
    public function first()
    {
        //
    }


    /**
     * Get one result
    */
    public function one()
    {
        //
    }
}