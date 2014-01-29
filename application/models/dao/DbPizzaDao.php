<?php
require_once 'PizzaDao.php';
require_once 'DbPizzaFlavorDao.php';
require_once APPPATH . 'models/domain/Pizza.php';
require_once APPPATH . 'models/domain/PizzaCrust.php';
require_once APPPATH . 'models/domain/PizzaEdge.php';
require_once APPPATH . 'models/domain/PizzaSize.php';
require_once APPPATH . 'models/domain/PizzaLayout.php';
require_once APPPATH . 'models/domain/PizzaFlavor.php';
/**
 * Class that persists a Pizza object in a Database.
 * It extends PizzaDao, so it will implement PizzaDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaDao extends PizzaDao
{
    /**
     * The table name!
     */
    private $table = 'pizzas';
    
    //Dry approach to the query creation
    private $idCol = 'id';
    private $nameCol = 'name';
    private $descriptionCol = 'description';
    private $picturePathCol = 'picture';
    private $crustCol = 'crust';
    private $edgeCol = 'edge';
    private $sizeCol = 'size';
    private $layoutCol = 'layout';
    private $obsCol = 'observations';
    private $flavor1Col = 'flavor1';
    private $flavor2Col = 'flavor2';
    private $flavor3Col = 'flavor3';
    private $flavor4Col = 'flavor4';
    
    //Other Table names
    private $crusts = 'crusts';
    private $edges = 'edges';
    private $sizes = 'sizes';
    private $layouts = 'layouts';
    private $flavors = 'flavors';
	
    
    /**
     * Constructor, sending the connection to the parent
     */
    public function __construct($conn) {
        parent::__construct($conn);		
    }
	
    public function fetch($id)
    {
    }
    
    public function delete($id) 
    {
        //stub
        return null;
    }

    /**
     * This function returns ALL PIZZAS available at the database.
     * The query was made with joins instead of separate queries
     * for each part of the pizza (crust, edge, size, layout, flavor1).
     * The only separate parts are the flavor2, 3 and 4, because they
     * can be null. So instead of creating a more complex query, I 
     * check if the additional flavors are valid. If so, I query them
     * individually (but that's not the common case, most pizzas have 1 flavor).
     * After querying I create the objects, populate them and return
     * them as an array.
     * @return type Pizza[] An array of pizzas
     */
    public function fetchAll() 
    {           
        //Returned Pizza List
        $pizzas = array();
        
        //Selects all Pizzas
        $query = "SELECT"
                //pizza columns
                ." p.{$this->idCol}"
                .",p.{$this->nameCol}"
                .",p.{$this->descriptionCol}" 
                .",p.{$this->picturePathCol}"
                .",p.{$this->obsCol}"
                .",p.{$this->flavor2Col}"
                .",p.{$this->flavor3Col}"
                .",p.{$this->flavor4Col}"
                //crust columns
                .",c.id as crustId"
                .",c.name as crustName"
                .",c.description as crustDescription"
                .",c.picture as crustPicturePath"
                //edge columns
                .",e.id as edgeId"
                .",e.name as edgeName"
                .",e.description as edgeDescription"
                .",e.filling as edgeFilling"
                .",e.picture as edgePicturePath"
                //size columns
                .",s.id as sizeId"
                .",s.name as sizeName"
                .",s.description as sizeDescription"
                .",s.picture as sizePicturePath"
                //layout columns
                .",l.id as layoutId"
                .",l.name as layoutName"
                .",l.description as layoutDescription"
                .",l.pattern as layoutPattern"
                .",l.picture as layoutPicturePath"
                //flavor1 columns
                .",f.id as flavor1Id"
                .",f.name as flavor1Name"
                .",f.description as flavor1Description"
                .",f.picture as flavor1PicturePath"
                        
                ." FROM"
                ." {$this->table} p"
                .",{$this->crusts} c"
                .",{$this->edges} e"
                .",{$this->sizes} s"
                .",{$this->layouts} l"
                .",{$this->flavors} f"
                ." WHERE"
                ." p.{$this->crustCol} = c.id"
                ." AND p.{$this->edgeCol} = e.id"
                ." AND p.{$this->sizeCol} = s.id"
                ." AND p.{$this->layoutCol} = l.id"
                ." AND p.{$this->flavor1Col} = f.id"
                ;

        //Executes the query
        $result = $this->connection->query($query);        
        
        //Checks if there's results
        if($result->num_rows() > 0 )
        {
            //For each Pizza found on table
            foreach($result->result() as $row)
            {
                //Instantiate a new Pizza
                $pizza = new Pizza();                
                
                //Creating the Crust
                $crust = new PizzaCrust();
                $crust->setId($row->crustId);
                $crust->setName($row->crustName);
                $crust->setDescription($row->crustDescription);
                $crust->setPicturePath($row->crustPicturePath);
                
                //Creating the Edge
                $edge = new PizzaEdge();
                $edge->setId($row->edgeId);
                $edge->setName($row->edgeName);
                $edge->setDescription($row->edgeDescription);
                $edge->setPicturePath($row->edgePicturePath);
                
                //Creating the Layout
                $layout = new PizzaLayout();
                $layout->setId($row->layoutId);
                $layout->setName($row->layoutName);
                $layout->setDescription($row->layoutDescription);
                $layout->setPattern($row->layoutPattern);
                $layout->setPicturePath($row->layoutPicturePath);
                
                //Creating the Size
                $size = new PizzaSize();
                $size->setId($row->sizeId);
                $size->setName($row->sizeName);
                $size->setDescription($row->sizeDescription);
                $size->setPicturePath($row->sizePicturePath);
            
                //Creating the mandatory Flavor                 
                $flavor = new PizzaFlavor();
                $flavor->setId($row->flavor1Id);
                $flavor->setName($row->flavor1Name);
                $flavor->setDescription($row->flavor1Description);
                $flavor->setPicturePath($row->flavor1PicturePath);
                
                //Initializing empty additional flavors
                $flavor2 = null;
                $flavor3 = null;
                $flavor4 = null;
                
                //Is there a Flavor 2?
                //Notice that a Flavor3 will only exist if 
                //there is one Flavor2. Flavor4 needs Flavor3.
                if(intval($row->flavor2) !== 0)
                {
                    //Initialize the FlavorDao
                    $flavorDao = new DbPizzaFlavorDao($this->connection);
                    
                    //Search for the flavor2
                    $flavor2 = $flavorDao->fetch($row->flavor2);
                    
                    //Is there a Flavor 3?
                    if(intval($row->flavor3) !== 0)
                    {
                        //Search for Flavor3
                        $flavor3 = $flavorDao->fetch($row->flavor3);
                        
                        //Is there a Flavor 4?
                        if(intval($row->flavor4) !== 0)
                        {
                            //Search for Flavor4
                            $flavor4 = $flavorDao->fetch($row->flavor4);
                        }
                    }
                }
                
                //Initializing Pizza attributes
                $pizza->setId($row->id);
                $pizza->setName($row->name);
                $pizza->setDescription($row->description);
                $pizza->setPicturePath($row->picture);
                $pizza->setObservations($row->observations);
                $pizza->setCrust($crust);
                $pizza->setEdge($edge);
                $pizza->setLayout($layout);
                $pizza->setSize($size);
                $pizza->setFlavor1($flavor);
                $pizza->setFlavor2($flavor2);
                $pizza->setFlavor3($flavor3);
                $pizza->setFlavor4($flavor4);
                
                //Add to the array
                $pizzas[] = $pizza;
            }
        }
        
        
        return $pizzas;
    }

    public function save(Dao $dao) 
    {
        //stub
        return null;
    }

}
/* End of file DbPizzaDao.php */
/* Location: ./application/controllers/DbPizzaDao.php */