<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain Ingredient.
 * It will be used by the models to access the persistant Ingredients objects
 */
abstract class IngredientDao implements Dao
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
/* End of file IngredientDao.php */
/* Location: ./application/controllers/IngredientDao.php */