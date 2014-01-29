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
        }
        
        
        return $flavor;
    }
    
    /**
     * Returns all pizza flavor records of the database
     * @return type \PizzaFlavor[] A list of all pizza flavors
     */
    public function fetchAll() 
    { 
        //Returned PizzaFlavor List
        $flavors = array();
        
        //Selects a PizzaFlavor by id
        $query = "SELECT"
                ." f.{$this->idCol}"
                .",f.{$this->nameCol}"
                .",f.{$this->descriptionCol}" 
                .",f.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} f";

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
                
                //Add to the array
                $flavors[] = $flavor;
            }
        }
        
        
        return $flavors;
    }
    
    public function delete($id) 
    {
        //stub
    }    

    public function save(Dao $dao) 
    {
        //stub
    }

}
/* End of file DbPizzaFlavorDao.php */
/* Location: ./application/controllers/DbPizzaFlavorDao.php */