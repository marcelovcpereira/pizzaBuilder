<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain PizzaFlavor.
 * It will be used by the models to access the persistant PizzaFlavor objects
 */
abstract class PizzaFlavorDao implements Dao
{

    protected $connection;
    

    public function __construct($conn)
    {
        $this->connection = $conn;
    }
    
    //To be overwritten by the Concrete SubClasses
    abstract public function fetch($id);
    abstract public function fetchAll();
    abstract public function delete($id);
    abstract public function save($object);
    
}
/* End of file PizzaFlavorDao.php */
/* Location: ./application/controllers/PizzaFlavorDao.php */