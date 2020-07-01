<?php
namespace Jan\Component\Database\Connection\PDO;


use Exception;
use PDO;


/**
 * Class Connection
 * @package Jan\Component\Database\Connection\PDO
*/
class Connection
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

            } catch (\PDOException $e) {

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
    */
    public function getDriverName() {}
}