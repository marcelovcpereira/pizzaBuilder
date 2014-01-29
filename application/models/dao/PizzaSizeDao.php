<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain PizzaSize (PizzaSize).
 * It will be used by the models to access the persistant PizzaSize objects
 * It can have specific features that only a PizzaSizeDao have (not all Dao).
 */
abstract class PizzaSizeDao implements Dao
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
/* End of file PizzaSizeDao.php */
/* Location: ./application/controllers/PizzaSizeDao.php */