<?php
require_once 'PizzaSizeDao.php';
require_once APPPATH . 'models/domain/PizzaSize.php';
/**
 * Class that persists a PizzaCrust object in a Database.
 * It extends PizzaCrustDao, so it will implement PizzaCrustDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaSizeDao extends PizzaSizeDao
{
    /**
     * The table name!
     */
    private $table = 'sizes';
    
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
     * Seeks for a Size by id
     * @param type $id
     * @return type PizzaSize
     */
    public function fetch($id)
    {
        //Returned Size object
        $size = null;
        
        //Selects a crust by id
        $query = "SELECT"
        ." s.{$this->idCol}"
        .",s.{$this->nameCol}"
        .",s.{$this->descriptionCol}" 
        .",s.{$this->picturePathCol}"
        ." FROM"
        ." {$this->table} s"
        ." WHERE"
        ." s.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new PizzaSize object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new PizzaSize
            //and let's initialize it.
            $size = new PizzaSize();
            $size->setId($row->id);
            $size->setName($row->name);
            $size->setDescription($row->description);
            $size->setPicturePath($row->picture);
        }
        
        
        return $size;
    }
    
    /**
     * Returns all pizza size records of the database
     * @return type \PizzaSize[] A list of all pizza crusts
     */
    public function fetchAll() 
    { 
        //the key value where this query will be cached     
        $key = 'allSizes';
        //5 hours to reset this cache
        $timeToLive = 18000;         
        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $sizes = $CI->cachewrapper->fetch($key);
        if($sizes === FALSE)
        {
            //Returned Size List
            $sizes = array();
            
            //Selects a size by id
            $query = "SELECT"
            ." s.{$this->idCol}"
            .",s.{$this->nameCol}"
            .",s.{$this->descriptionCol}" 
            .",s.{$this->picturePathCol}"
            ." FROM"
            ." {$this->table} s";

            //Executes the query
            $result = $this->connection->query($query);        
            
            //Checks if there's results
            if($result->num_rows() > 0 )
            {
                //For each size found on table
                foreach($result->result() as $row)
                {
                    //Instantiate a new PizzaSize
                    //and let's initialize it.
                    $size = new PizzaSize();
                    $size->setId($row->id);
                    $size->setName($row->name);
                    $size->setDescription($row->description);
                    $size->setPicturePath($row->picture);
                    
                    //Add to the array
                    $sizes[] = $size;
                }
                /*
                 * Caching the crust types
                 */ 
                $CI->cachewrapper->add($key,$sizes,$timeToLive);
            }
        }
        
        return $sizes;
    }
    
    public function delete($id) 
    {
        //stub
    }    

    public function save($object) 
    {
        //stub
    }

}
/* End of file DbPizzaCrustDao.php */
/* Location: ./application/controllers/DbPizzaCrustDao.php */