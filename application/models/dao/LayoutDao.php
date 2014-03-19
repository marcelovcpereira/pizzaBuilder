<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain Layout (PizzaLayout).
 * It will be used by the models to access the persistant Layout objects
 * It should have implementations like DbLayoutDao, FileLayoutDao, CloudLayoutDao,
 * or any additional type of persistance. The model layer is completely
 * unaware of the persistance type.
 * It can have specific features that only a LayoutDao have (not all Dao).
 */
abstract class LayoutDao implements Dao
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
/* End of file LayoutDao.php */
/* Location: ./application/controllers/LayoutDao.php */