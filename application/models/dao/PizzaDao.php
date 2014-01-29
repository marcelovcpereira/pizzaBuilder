<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain Pizza.
 * It will be used by the models to access the persistant Pizza objects
 * It should have implementations like DbPizzaDao, FilePizzaDao, CloudPizzaDao,
 * or any additional type of persistance. The model layer is completely
 * unaware of the persistance type.
 * It can have specific features that only a PizzaDao have.
 */
abstract class PizzaDao implements Dao
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
/* End of file PizzaDao.php */
/* Location: ./application/controllers/PizzaDao.php */