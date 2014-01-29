<?php
require_once 'IngredientDao.php';
require_once APPPATH . 'models/domain/Ingredient.php';
/**
 * Class that persists a User object in a Database.
 * It extends IngredientDao, so it will implement IngredientDao's abstract methods:
 * save,fetch and delete. 
 */
class DbIngredientDao extends IngredientDao
{
    /**
     * The table name!
     */
    private $table = 'ingredients';
    
    //Dry approach to the query creation
    private $idCol = 'id';
    private $nameCol = 'name';
    private $descriptionCol = 'description';
    private $picturePathCol = 'picture';
	
    
    /**
     * Constructor, sending the connection to the parent
     */
    public function __construct($conn) {
        parent::__construct($conn);		
    }
	
    /**
     * Seeks for an Ingredient by id
     * @param type $id
     * @return type PizzaIngredient
     */
    public function fetch($id)
    {
        //Returned Ingredient object
        $ingredient = null;
        
        //Selects a Ingredient by id
        $query = "SELECT"
                ." i.{$this->idCol}"
                .",i.{$this->nameCol}"
                .",i.{$this->descriptionCol}" 
                .",i.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} i"
                ." WHERE"
                ." i.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new Ingredient object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new Ingredient
            //and let's initialize it.
            $ingredient = new Ingredient();
            $ingredient->setId($row->id);
            $ingredient->setName($row->name);
            $ingredient->setDescription($row->description);
            $ingredient->setPicturePath($row->picture);
        }
        
        
        return $ingredient;
    }
    
    public function delete($id) 
    {
        //stub
        return null;
    }

    /**
     * 
     * @return type Ingredient[] An array of Ingredient
     */
    public function fetchAll() 
    {           
       //this function will return a list of all Ingredients
       //at the database table
       //Returned Ingredient List
        $ingredients = array();
        
        //Selects an $ingredient by id
        $query = "SELECT"
                ." i.{$this->idCol}"
                .",i.{$this->nameCol}"
                .",i.{$this->descriptionCol}" 
                .",i.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} i";

        //Executes the query
        $result = $this->connection->query($query);        
        
        //Checks if there's results
        if($result->num_rows() > 0 )
        {
            //For each $ingredient found on table
            foreach($result->result() as $row)
            {
                //Instantiate a new $ingredient
                //and let's initialize it.
                $ingredient = new Ingredient();
                $ingredient->setId($row->id);
                $ingredient->setName($row->name);
                $ingredient->setDescription($row->description);
                $ingredient->setPicturePath($row->picture);
                
                //Add to the array
                $ingredients[] = $ingredient;
            }
        }
        
        
        return $ingredients;
    }

    public function save(Dao $dao) 
    {
        //stub
        return null;
    }

}
/* End of file DbIngredientDao.php */
/* Location: ./application/controllers/DbIngredientDao.php */