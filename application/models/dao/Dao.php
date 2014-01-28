<?php

/* 
 * This class indicates what a DAO should do.
 * Every DAO object should be able to execute the CRUD operations.
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class Dao
{
    protected $connection;
    
    public function __construct($conn) {
        $this->setConnection($conn);
    }
    
    public function getConnection() {
        return $this->connection;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
    }

    abstract public function fetch($id);
    abstract public function delete();
    abstract public function save();
    
}



