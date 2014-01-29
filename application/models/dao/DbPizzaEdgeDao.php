<?php
require_once 'PizzaEdgeDao.php';
require_once APPPATH . 'models/domain/PizzaEdge.php';
/**
 * Class that persists a PizzaEdge object in a Database.
 * It extends PizzaEdgeDao, so it will implement PizzaEdgeDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaEdgeDao extends PizzaEdgeDao
{
    /**
     * The table name!
     */
    private $table = 'edges';
    
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
     * Seeks for an Edge by id
     * @param type $id
     * @return type PizzaEdge
     */
    public function fetch($id)
    {
        //Returned Edge object
        $edge = null;
        
        //Selects a edge by id
        $query = "SELECT"
                ." e.{$this->idCol}"
                .",e.{$this->nameCol}"
                .",e.{$this->descriptionCol}" 
                .",e.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} e"
                ." WHERE"
                ." e.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query,array($id));        
        
        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new PizzaEdge object
        //Else, keep the null object
        if($result->num_rows() === 1)
        {
            //Get the result row
            $row = $result->row();
            
            //Instantiate a new PizzaEdge
            //and let's initialize it.
            $edge = new PizzaEdge();
            $edge->setId($row->id);
            $edge->setName($row->name);
            $edge->setDescription($row->description);
            $edge->setPicturePath($row->picture);
        }
        
        
        return $edge;
    }
    
    /**
     * Returns all pizza edge records of the database
     * @return type \PizzaEdge[] A list of all pizza edges
     */
    public function fetchAll() 
    { 
        //Returned edges List
        $edges = array();
        
        //Selects a edge by id
        $query = "SELECT"
                ." e.{$this->idCol}"
                .",e.{$this->nameCol}"
                .",e.{$this->descriptionCol}" 
                .",e.{$this->picturePathCol}"
                ." FROM"
                ." {$this->table} e";

        //Executes the query
        $result = $this->connection->query($query);        
        
        //Checks if there's results
        if($result->num_rows() > 0 )
        {
            //For each edge found on table
            foreach($result->result() as $row)
            {
                //Instantiate a new PizzaEdge
                //and let's initialize it.
                $edge = new PizzaEdge();
                $edge->setId($row->id);
                $edge->setName($row->name);
                $edge->setDescription($row->description);
                $edge->setPicturePath($row->picture);
                
                //Add to the array
                $edges[] = $edge;
            }
        }
        
        
        return $edges;
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
/* End of file DbPizzaEdgeDao.php */
/* Location: ./application/controllers/DbPizzaEdgeDao.php */