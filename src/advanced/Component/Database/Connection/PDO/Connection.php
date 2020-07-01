<?php
namespace Jan\Component\Database\Connection\PDO;


use Closure;
use Exception;
use Jan\Component\Database\Connection\ConnectionInterface;
use PDO;
use PDOException;
use PDOStatement;
use stdClass;


/**
 * Class Connection
 * @package Jan\Component\Database\Connection\PDO
*/
class Connection implements ConnectionInterface
{

    const DEFAULT_PDO_OPTIONS = [
        PDO::ATTR_PERSISTENT => true, // permit to insert/ persist data in to database
        PDO::ATTR_EMULATE_PREPARES => 0,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];


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
     * @var string
    */
    private $classMap;  /* stdClass::class */



    /**
     * Driver constructor.
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array $options
     * @throws Exception
    */
    public function __construct(string $dsn, ?string $username, ?string $password, array $options = [])
    {
        if(\in_array($this->getDriverName(), PDO::getAvailableDrivers()))
        {
            try {

                if(! $this->isConnected())
                {
                    $this->pdo = new PDO(
                        $dsn,
                        $username,
                        $password,
                        array_merge(self::DEFAULT_PDO_OPTIONS, $options)
                    );
                }

            } catch (PDOException $e) {

                 throw $e;
            }
        }
    }


    /**
     * @return bool
    */
    public function isConnected()
    {
        return $this->pdo instanceof PDO;
    }


    /**
     * @return PDO
    */
    public function getConnection()
    {
        return $this->pdo;
    }


    /**
     * Get driver name
     *
     * @return string
     * @throws Exception
    */
    public function getDriverName()
    {
         throw new Exception('You must to set driver name!');
    }


    /**
     * @param string $sql
     * @param array $params
     * @param string $classMap
     * @return Connection
    */
    public function query($sql, $params = [], $classMap = null)
    {
        try {

            $this->statement = $this->pdo->prepare($sql);

            if($this->statement->execute($params))
            {
                $this->records[] = compact('sql', 'params');
            }

            $this->classMap = $classMap;

        } catch (PDOException $e) {

            throw $e;
        }

        return $this;
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
            $callback();
            $this->commit();

        } catch (PDOException $e) {

            $this->rollback();
            throw $e;
        }
    }



    /**
     * @param string $sql
     * @throws Exception
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