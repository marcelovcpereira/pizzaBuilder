<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain PizzaCrust.
 * It will be used by the models to access the persistant PizzaCrust objects
 */
abstract class PizzaCrustDao implements Dao
{
    
    protected $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }
    
    //To be overwritten by the Concrete SubClasses
    abstract public function fetch($id);
    abstract public function fetchAll();
    abstract public function delete($object);
    abstract public function save($object);
	
    
}
/* End of file PizzaCrustDao.php */
/* Location: ./application/controllers/PizzaCrustDao.php */