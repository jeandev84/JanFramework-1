<?php
namespace Jan\Component\Database\Connection\MySqli;


use Jan\Component\Database\Connection\ConnectionInterface;



/**
 * Class Connection
 * @package Jan\Component\Database\Connection\MySqli
*/
class Connection implements ConnectionInterface
{

    /**
     * @return mixed
    */
    public function getConnection()
    {
        return 'something';
    }


    /**
     * @param string $sql
     * @return mixed
    */
    public function query($sql)
    {
        //
    }
}