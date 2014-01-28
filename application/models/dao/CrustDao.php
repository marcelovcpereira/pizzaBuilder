<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain Crust (PizzaCrust).
 * It will be used by the models to access the persistant crusts objects
 * It should have implementations like DbCrustDao, FileCrustDao, CloudCrustDao,
 * or any additional type of persistance. The model layer is completely
 * unaware of the persistance type.
 * It can have specific features that only a CrustDao have (not all Dao).
 */
abstract class CrustDao implements Dao
{

    protected $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }
    
    //To be overwritten by the Concrete SubClasses
    abstract public function fetch($id);
    abstract public function delete();
    abstract public function save();
    
}


