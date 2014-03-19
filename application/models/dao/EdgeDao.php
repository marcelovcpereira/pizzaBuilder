<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain Edge (PizzaEdge).
 * It will be used by the models to access the persistant edge objects
 * It should have implementations like DbEdgeDao, FileEdgeDao, CloudEdgeDao,
 * or any additional type of persistance. The model layer is completely
 * unaware of the persistance type.
 * It can have specific features that only a EdgeDao have (not all Dao).
 */
abstract class EdgeDao implements Dao
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
/* End of file EdgeDao.php */
/* Location: ./application/controllers/EdgeDao.php */