<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain PizzaEdge.
 * It will be used by the models to access the persistant PizzaEdge objects
 * It can have specific features that only a PizzaEdgeDao have (not all Dao).
 */
abstract class PizzaEdgeDao implements Dao
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
    abstract public function save(Dao $dao);
    
}
/* End of file PizzaEdgeDao.php */
/* Location: ./application/controllers/PizzaEdgeDao.php */