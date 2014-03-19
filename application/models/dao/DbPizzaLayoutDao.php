<?php
require_once 'PizzaLayoutDao.php';
require_once APPPATH . 'models/domain/PizzaLayout.php';
/**
 * Class that persists a PizzaLayout object in a Database.
 * It extends PizzaLayoutDao, so it will implement PizzaLayoutDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaLayoutDao extends PizzaLayoutDao
{
    /**
     * The table name!
     */
    private $table = 'layouts';
    
    //Dry approach to the query creation
    private $idCol = 'id';
    private $nameCol = 'name';
    private $descriptionCol = 'description';
    private $patternCol = 'pattern';
    private $picturePathCol = 'picture';
    
    /**
     * Constructor, sending the connection to the parent
     */
    public function __construct($conn) {
        parent::__construct($conn);		
    }

    /**
     * Seeks for a Layout by id
     * @param type $id
     * @return type PizzaSize
     */
    public function fetch($id)
    {
        //Returned Size object
        $layout = null;
        
        //Selects a crust by id
        $query = "SELECT"
                ." l.{$this->idCol}"
                .",l.{$this->nameCol}"
                .",l.{$this->descriptionCol}"
                .",l.{$this->patternCol}" 
                .",l.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} l"
                ." WHERE"
                ." l.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new PizzaLayout object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new PizzaSize
            //and let's initialize it.
            $layout = new PizzaLayout();
            $layout->setId($row->id);
            $layout->setName($row->name);
            $layout->setDescription($row->description);
            $layout->setPattern($row->pattern);
            $layout->setPicturePath($row->picture);
        }
        
        
        return $layout;
    }
    
    /**
     * Returns all pizza layout records of the database
     * @return type \PizzaLayout[] A list of all pizza layouts
     */
    public function fetchAll() 
    { 
        //the key value where this query will be cached     
        $key = 'allLayouts';
        //5 hours to reset this cache
        $timeToLive = 18000;         
        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $layouts = $CI->cachewrapper->fetch($key);
        if($layouts === FALSE)
        {
            //Returned layout List
            $layouts = array();
            
            //Selects a layout by id
            $query = "SELECT"
                    ." l.{$this->idCol}"
                    .",l.{$this->nameCol}"
                    .",l.{$this->descriptionCol}"
                    .",l.{$this->patternCol}" 
                    .",l.{$this->picturePathCol}"
                    ." FROM"
                    ." {$this->table} l";

            //Executes the query
            $result = $this->connection->query($query);        
            
            //Checks if there's results
            if($result->num_rows() > 0 )
            {
                //For each layout found on table
                foreach($result->result() as $row)
                {
                    //Instantiate a new PizzaLayout
                    //and let's initialize it.
                    $layout = new PizzaLayout();
                    $layout->setId($row->id);
                    $layout->setName($row->name);
                    $layout->setDescription($row->description);
                    $layout->setPattern($row->pattern);
                    $layout->setPicturePath($row->picture);
                    
                    //Add to the array
                    $layouts[] = $layout;
                }
                /*
                 * Caching all layouts
                 */ 
                $CI->cachewrapper->add($key,$layouts,$timeToLive);
            }
        }
        
        return $layouts;
    }
    
    public function delete($object) 
    {
        //stub
    }    

    public function save($object) 
    {
        //stub
    }

}
/* End of file DbPizzaLayoutDao.php */
/* Location: ./application/controllers/DbPizzaLayoutDao.php */