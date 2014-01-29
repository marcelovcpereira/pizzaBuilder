<?php
require_once 'PizzaCrustDao.php';
require_once APPPATH . 'models/domain/PizzaCrust.php';
/**
 * Class that persists a PizzaCrust object in a Database.
 * It extends PizzaCrustDao, so it will implement PizzaCrustDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaCrustDao extends PizzaCrustDao
{
    /**
     * The table name!
     */
    private $table = 'crusts';
    
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
     * Seeks for a Crust by id
     * @param type $id
     * @return type PizzaCrust
     */
    public function fetch($id)
    {
        //Returned Crust object
        $crust = null;
        
        //Selects a crust by id
        $query = "SELECT"
                ." c.{$this->idCol}"
                .",c.{$this->nameCol}"
                .",c.{$this->descriptionCol}" 
                .",c.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} c"
                ." WHERE"
                ." c.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new PizzaCrust object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new PizzaCrust
            //and let's initialize it.
            $crust = new PizzaCrust();
            $crust->setId($row->id);
            $crust->setName($row->name);
            $crust->setDescription($row->description);
            $crust->setPicturePath($row->picture);
        }
        
        
        return $crust;
    }
    
    /**
     * Returns all pizza crusts records of the database
     * @return type \PizzaCrust[] A list of all pizza crusts
     */
    public function fetchAll() 
    { 
        //Returned Crust List
        $crusts = array();
        
        //Selects a crust by id
        $query = "SELECT"
                ." c.{$this->idCol}"
                .",c.{$this->nameCol}"
                .",c.{$this->descriptionCol}" 
                .",c.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} c";

        //Executes the query
        $result = $this->connection->query($query);        
        
        //Checks if there's results
        if($result->num_rows() > 0 )
        {
            //For each crust found on table
            foreach($result->result() as $row)
            {
                //Instantiate a new PizzaCrust
                //and let's initialize it.
                $crust = new PizzaCrust();
                $crust->setId($row->id);
                $crust->setName($row->name);
                $crust->setDescription($row->description);
                $crust->setPicturePath($row->picture);
                
                //Add to the array
                $crusts[] = $crust;
            }
        }
        
        
        return $crusts;
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