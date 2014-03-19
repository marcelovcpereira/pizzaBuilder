<?php
require_once 'PizzaFlavorDao.php';
require_once APPPATH . 'models/domain/PizzaFlavor.php';
/**
 * Class that persists a PizzaFlavor object in a Database.
 * It extends PizzaFlavorDao, so it will implement PizzaFlavorDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaFlavorDao extends PizzaFlavorDao
{
    /**
     * The table name!
     */
    private $table = 'flavors';
    private $flavor_ingredients = 'flavor_ingredients';
    private $ingredientsTable = 'ingredients';
    
    //Dry approach to the query creation
    private $idCol = 'id';
    private $nameCol = 'name';
    private $descriptionCol = 'description';
    private $picturePathCol = 'picture';
    private $typeCol = 'type';
    
    /**
     * Constructor, sending the connection to the parent
     */
    public function __construct($conn) {
        parent::__construct($conn);		
    }

    /**
     * Seeks for an PizzaFlavor by id
     * @param type $id
     * @return type PizzaFlavor
     */
    public function fetch($id)
    {
        //Returned flavor object
        $flavor = null;
        
        //Selects a $flavor by id
        $query = "SELECT"
                ." f.{$this->idCol}"
                .",f.{$this->nameCol}"
                .",f.{$this->descriptionCol}" 
                .",f.{$this->picturePathCol}"
                . ",f.{$this->typeCol}"
                ." FROM"
                ." {$this->table} f"
                ." WHERE"
                ." f.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new $flavor object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new $flavor
            //and let's initialize it.
            $flavor = new PizzaFlavor();
            $flavor->setId($row->id);
            $flavor->setName($row->name);
            $flavor->setDescription($row->description);
            $flavor->setPicturePath($row->picture);
            $flavor->setType($row->type);
            
            //Querying for the ingredients of this flavor
            $ingredients = $this->getIngredients($flavor->getId());
            
            //Set the ingredient array to the flavor
            $flavor->setIngredients($ingredients);
        }
        
        
        return $flavor;
    }
    
    /**
     * Returns all pizza flavor records of the database
     * @return type \PizzaFlavor[] A list of all pizza flavors
     */
    public function fetchAll($includeUser=false) 
    { 
        //the key value where this query will be cached     
        $key = 'allFlavors';
        //5 hours to reset this cache
        $timeToLive = 18000;         
        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $flavors = $CI->cachewrapper->fetch($key);
        if($flavors === FALSE || true)
        {
            //Returned PizzaFlavor List
            $flavors = array();
            
            //Selects a PizzaFlavor by id
            $query = "SELECT"
                    ." f.{$this->idCol}"
                    .",f.{$this->nameCol}"
                    .",f.{$this->descriptionCol}" 
                    .",f.{$this->picturePathCol}"
                    .",f.{$this->typeCol}"
                    ." FROM"
                    ." {$this->table} f";
            if(!$includeUser)
            {
                $query .= " WHERE f.type = 'system'";
            }

            //Executes the query
            $result = $this->connection->query($query);        
            
            //Checks if there's results
            if($result->num_rows() > 0 )
            {
                //For each PizzaFlavor found on table
                foreach($result->result() as $row)
                {
                    //Instantiate a new PizzaFlavor
                    //and let's initialize it.
                    $flavor = new PizzaFlavor();
                    $flavor->setId($row->id);
                    $flavor->setName($row->name);
                    $flavor->setDescription($row->description);
                    $flavor->setPicturePath($row->picture);
                    $flavor->setType($row->type);
                    
                    //Querying for the ingredients of this flavor
                    $ingredients = $this->getIngredients($flavor->getId());

                    //Set the ingredient array to the flavor
                    $flavor->setIngredients($ingredients);
                    
                    //Add to the array
                    $flavors[] = $flavor;
                }
                /*
                 * Caching all flavors
                 */ 
                $CI->cachewrapper->add($key,$flavors,$timeToLive);
            }
        }
        
        return $flavors;
    }
    
    public function delete($object) 
    {
        if($object instanceof PizzaFlavor && $object->getType() == 'user')
        {
            /* removing flavor_ingredients */
            $this->connection->where('flavorId',$object->getId());
            $this->connection->delete($this->flavor_ingredients);

            /* removing the flavor */
            $this->connection->where('id', $object->getId());
            $this->connection->delete($this->table,$obj);
        }
    }    

    public function save($object) 
    {
        if($object instanceof PizzaFlavor && $object->getId() == -1)
        {
            $flavorObj = array(
                'name' => $object->getName(),
                'description' => $object->getDescription(),
                'picture' => $object->getPicturePath(),
                'type' => 'user' 
            );

            /* if this is a custom Flavor, add this new flavor row */
            $this->connection->insert($this->table,$flavorObj);
            $object->setId($this->connection->insert_id());

            /* linking ingredients to this new flavor (flavor_ingredients table)*/
            foreach($object->getIngredients() as $ingredient)
            {
                $ingreObj = array(
                    'flavorId' => $object->getId(),
                    'ingredientId' => $ingredient->getId()
                );
                $this->connection->insert($this->flavor_ingredients,$ingreObj);
            }

        }
    }
    
    /**
     * Searchs for all the ingredients of a given Flavor
     * @param type int $flavorId
     * @return Ingredient[] ingredients array
     */
    public function getIngredients($flavorId)
    {
        //Returned array
        $ingredients = array();
        
        $query = "SELECT i.id, i.name, i.description, i.picture"
                ." FROM {$this->flavor_ingredients} fi"
                .",{$this->ingredientsTable} i"
                ." WHERE"
                ." fi.flavorId = ?"
                ." AND fi.ingredientId = i.id"
                ;
        
        //Executes the query with the specified prepared statement ($flavorId)
        $result = $this->connection->query($query,array($flavorId));
        
        //If this flavor has ingredients, lets populate
        if($result->num_rows() > 0)
        {
            //Foreach ingredient create an object and add to array
            foreach($result->result() as $row)
            {
                $ingredient = new Ingredient();
                $ingredient->setId($row->id);
                $ingredient->setName($row->name);
                $ingredient->setDescription($row->description);
                $ingredient->setPicturePath($row->picture);
                
                $ingredients[] = $ingredient;
            }
        }
        return $ingredients;
    }

}
/* End of file DbPizzaFlavorDao.php */
/* Location: ./application/controllers/DbPizzaFlavorDao.php */