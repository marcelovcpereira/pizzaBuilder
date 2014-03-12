<?php

require_once 'PizzaDao.php';
require_once 'DbPizzaFlavorDao.php';
require_once 'DbIngredientDao.php';

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
class DbPizzaDao extends PizzaDao {

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
    //Other Table names
    private $crusts = 'crusts';
    private $edges = 'edges';
    private $sizes = 'sizes';
    private $layouts = 'layouts';
    private $flavors = 'flavors';
    private $ingredients = 'ingredients';
    private $pizza_pizzaFlavors = 'pizza_pizzaflavors';

    /**
     * Constructor, sending the connection to the parent
     */
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function fetch($id) {
        /*
         * Trying to fetch from cache.
         * If it's not cached, execute all the method and cache it.
         */

        //the key value where this query will be cached		
        $key = 'pizza' . $id;
        //5 hours to reset this cache
        $timeToLive = 18000;

        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $pizza = $CI->cachewrapper->fetch($key);

        //If key not found in cache, create and cache it
        if ($pizza === FALSE) {
            //Selects all Pizzas
            $query = "SELECT"
                    //pizza columns
                    . " p.{$this->idCol}"
                    . ",p.{$this->nameCol}"
                    . ",p.{$this->descriptionCol}"
                    . ",p.{$this->picturePathCol}"
                    . ",p.{$this->obsCol}"
                    //crust columns
                    . ",c.id as crustId"
                    . ",c.name as crustName"
                    . ",c.description as crustDescription"
                    . ",c.picture as crustPicturePath"
                    //edge columns
                    . ",e.id as edgeId"
                    . ",e.name as edgeName"
                    . ",e.description as edgeDescription"
                    . ",e.filling as edgeFilling"
                    . ",e.picture as edgePicturePath"
                    //size columns
                    . ",s.id as sizeId"
                    . ",s.name as sizeName"
                    . ",s.description as sizeDescription"
                    . ",s.picture as sizePicturePath"
                    //layout columns
                    . ",l.id as layoutId"
                    . ",l.name as layoutName"
                    . ",l.description as layoutDescription"
                    . ",l.pattern as layoutPattern"
                    . ",l.picture as layoutPicturePath"
                    . " FROM"
                    . " {$this->table} p"
                    . ",{$this->crusts} c"
                    . ",{$this->edges} e"
                    . ",{$this->sizes} s"
                    . ",{$this->layouts} l"
                    . " WHERE"
                    . " p.{$this->crustCol} = c.id"
                    . " AND p.{$this->edgeCol} = e.id"
                    . " AND p.{$this->sizeCol} = s.id"
                    . " AND p.{$this->layoutCol} = l.id"
                    . " AND p.{$this->idCol} = {$id}";


            //Executes the query
            $result = $this->connection->query($query);

            //Checks if the pizza was found
            if ($result->num_rows() == 1) {
                $row = $result->row();
                //Instantiate a new Pizza
                $pizza = new Pizza();
                //Initializing scalar attributes
                $pizza->setId($row->id);
                $pizza->setName($row->name);
                $pizza->setDescription($row->description);
                $pizza->setPicturePath($row->picture);
                $pizza->setObservations($row->observations);

                //Create the Crust
                $crust = new PizzaCrust();
                $crust->setId($row->crustId);
                $crust->setName($row->crustName);
                $crust->setDescription($row->crustDescription);
                $crust->setPicturePath($row->crustPicturePath);

                //Create the Edge
                $edge = new PizzaEdge();
                $edge->setId($row->edgeId);
                $edge->setName($row->edgeName);
                $edge->setDescription($row->edgeDescription);
                $edge->setPicturePath($row->edgePicturePath);

                //If the Edge has a filling ingredient, let's
                //create it and set to the edge
                if (intval($row->edgeFilling) !== 0) {
                    //Initialize the IngredientDao (for the edge filling)
                    $ingredientDao = new DbIngredientDao($this->connection);

                    //Search for the ingredient
                    $filling = $ingredientDao->fetch($row->edgeFilling);

                    //Adding it to the Edge
                    $edge->setFilling($filling);
                }

                //Create the Layout
                $layout = new PizzaLayout();
                $layout->setId($row->layoutId);
                $layout->setName($row->layoutName);
                $layout->setDescription($row->layoutDescription);
                $layout->setPattern($row->layoutPattern);
                $layout->setPicturePath($row->layoutPicturePath);

                //Create the Size
                $size = new PizzaSize();
                $size->setId($row->sizeId);
                $size->setName($row->sizeName);
                $size->setDescription($row->sizeDescription);
                $size->setPicturePath($row->sizePicturePath);


                //Search pizza flavors
                $tmpFlavor = null;
                $flavors = array();
                $flavorDao = new DbPizzaFlavorDao($this->connection);

                $query = "SELECT"
                        . " f.id, f.name,f.description, f.picture,"
                        . "ppf.flavorPosition as position"
                        . " FROM {$this->pizza_pizzaFlavors} ppf,"
                        . " {$this->flavors} f"
                        . " WHERE ppf.pizzaId = {$row->id}"
                        . " AND ppf.flavorId = f.id";
                //Executes the query
                $result = $this->connection->query($query);
                foreach ($result->result() as $row) {
                    $tmpFlavor = new PizzaFlavor();
                    $tmpFlavor->setId($row->id);
                    $tmpFlavor->setName($row->name);
                    $tmpFlavor->setDescription($row->description);
                    $tmpFlavor->setPicturePath($row->picture);

                    //Search for the flavor ingredients					
                    $ingredients = $flavorDao->getIngredients($tmpFlavor->getId());
                    //Add ingredients to the flavor
                    $tmpFlavor->setIngredients($ingredients);

                    $flavors[$row->position] = $tmpFlavor;
                }

                //Initializing Object attributes
                $pizza->setCrust($crust);
                $pizza->setEdge($edge);
                $pizza->setLayout($layout);
                $pizza->setSize($size);
                $pizza->setFlavors($flavors);
                /*
                 * The menu of a store does not change very much,
                 * so we can cache it for 5 hours (or forever...).
                 */
                $CI->cachewrapper->add($key, $pizza, $timeToLive);
            } else {
                $pizza = null;
            }
        }

        return $pizza;
    }

    public function delete($id) {
        //stub
        return null;
    }

    /**
     * This function returns ALL available PIZZAS at the database.
     * The query was made with joins instead of separate queries
     * for each part of the pizza (crust, edge, size, layout, flavor1)
     * for performance reasons.
     * 
     * There are, though, some separate parts: the flavors 2, 3 and 4 can be null. 
     * So instead of creating a more complex query*, I check if the additional 
     * flavors are valid. If so, I query them individually 
     * (but that's not the common case, most pizzas have 1 flavor).
     * Also each Flavor has an array of ingredients, so this is also
     * a separate search. 
     * Another separate query is the EdgeFilling that can also be null.
     * If the filling ID is valid, search for the edge filling ingredient.
     * After querying, create the objects, populate them and return
     * them as an array.
     * (*)mysql can't mix right and left joins
     * 
     * @return type Pizza[] An array of pizzas
     */
    public function fetchAll() {
        /*
         * Trying to fetch from cache.
         * If it's not cached, execute all the method and cache it.
         */

        //the key value where this query will be cached		
        $key = 'allPizzas';
        //5 hours to reset this cache
        $timeToLive = 18000;

        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $pizzas = $CI->cachewrapper->fetch($key);

        //If key not found in cache, create and cache it
        if ($pizzas === FALSE) {
            //Returned Pizza List
            $pizzas = array();

            //Selects all Pizzas
            $query = "SELECT"
                    //pizza columns
                    . " p.{$this->idCol}"
                    . ",p.{$this->nameCol}"
                    . ",p.{$this->descriptionCol}"
                    . ",p.{$this->picturePathCol}"
                    . ",p.{$this->obsCol}"
                    //crust columns
                    . ",c.id as crustId"
                    . ",c.name as crustName"
                    . ",c.description as crustDescription"
                    . ",c.picture as crustPicturePath"
                    //edge columns
                    . ",e.id as edgeId"
                    . ",e.name as edgeName"
                    . ",e.description as edgeDescription"
                    . ",e.filling as edgeFilling"
                    . ",e.picture as edgePicturePath"
                    //size columns
                    . ",s.id as sizeId"
                    . ",s.name as sizeName"
                    . ",s.description as sizeDescription"
                    . ",s.picture as sizePicturePath"
                    //layout columns
                    . ",l.id as layoutId"
                    . ",l.name as layoutName"
                    . ",l.description as layoutDescription"
                    . ",l.pattern as layoutPattern"
                    . ",l.picture as layoutPicturePath"
                    . " FROM"
                    . " {$this->table} p"
                    . ",{$this->crusts} c"
                    . ",{$this->edges} e"
                    . ",{$this->sizes} s"
                    . ",{$this->layouts} l"
                    . " WHERE"
                    . " p.{$this->crustCol} = c.id"
                    . " AND p.{$this->edgeCol} = e.id"
                    . " AND p.{$this->sizeCol} = s.id"
                    . " AND p.{$this->layoutCol} = l.id";


            //Executes the query
            $result = $this->connection->query($query);

            //Checks if there's results
            if ($result->num_rows() > 0) {
                //For each Pizza found on table
                foreach ($result->result() as $row) {
                    //Instantiate a new Pizza
                    $pizza = new Pizza();
                    //Initializing scalar attributes
                    $pizza->setId($row->id);
                    $pizza->setName($row->name);
                    $pizza->setDescription($row->description);
                    $pizza->setPicturePath($row->picture);
                    $pizza->setObservations($row->observations);
                    
                    //Create the Crust
                    $crust = new PizzaCrust();
                    $crust->setId($row->crustId);
                    $crust->setName($row->crustName);
                    $crust->setDescription($row->crustDescription);
                    $crust->setPicturePath($row->crustPicturePath);

                    //Create the Edge
                    $edge = new PizzaEdge();
                    $edge->setId($row->edgeId);
                    $edge->setName($row->edgeName);
                    $edge->setDescription($row->edgeDescription);
                    $edge->setPicturePath($row->edgePicturePath);

                    //If the Edge has a filling ingredient, let's
                    //create it and set to the edge
                    if (intval($row->edgeFilling) !== 0) {
                        //Initialize the IngredientDao (for the edge filling)
                        $ingredientDao = new DbIngredientDao($this->connection);

                        //Search for the ingredient
                        $filling = $ingredientDao->fetch($row->edgeFilling);

                        //Adding it to the Edge
                        $edge->setFilling($filling);
                    }

                    //Create the Layout
                    $layout = new PizzaLayout();
                    $layout->setId($row->layoutId);
                    $layout->setName($row->layoutName);
                    $layout->setDescription($row->layoutDescription);
                    $layout->setPattern($row->layoutPattern);
                    $layout->setPicturePath($row->layoutPicturePath);

                    //Create the Size
                    $size = new PizzaSize();
                    $size->setId($row->sizeId);
                    $size->setName($row->sizeName);
                    $size->setDescription($row->sizeDescription);
                    $size->setPicturePath($row->sizePicturePath);

                    //Search pizza flavors
                    $tmpFlavor = null;
                    $flavors = array();
                    $flavorDao = new DbPizzaFlavorDao($this->connection);

                    $query = "SELECT"
                            . " f.id, f.name,f.description, f.picture"
                            . ",ppf.flavorPosition as position"
                            . " FROM {$this->pizza_pizzaFlavors} ppf"
                            . " ,{$this->flavors} f"
                            . " WHERE ppf.pizzaId = {$row->id}"
                            . " AND ppf.flavorId = f.id";
                    //Executes the query
                    $result = $this->connection->query($query);
                    foreach ($result->result() as $row) {
                        $tmpFlavor = new PizzaFlavor();
                        $tmpFlavor->setId($row->id);
                        $tmpFlavor->setName($row->name);
                        $tmpFlavor->setDescription($row->description);
                        $tmpFlavor->setPicturePath($row->picture);

                        //Search for the flavor ingredients					
                        $ingredients = $flavorDao->getIngredients($tmpFlavor->getId());
                        //Add ingredients to the flavor
                        $tmpFlavor->setIngredients($ingredients);

                        $flavors[$row->position] = $tmpFlavor;
                    }

                    
                    $pizza->setCrust($crust);
                    $pizza->setEdge($edge);
                    $pizza->setLayout($layout);
                    $pizza->setSize($size);                   
                    $pizza->setFlavors($flavors);
                    
                    //Add to the array
                    $pizzas[] = $pizza;
                }
                /*
                 * The menu of a store does not change very much,
                 * so we can cache it for 5 hours (or forever...).
                 */
                //apcu_add($key,$pizzas, $timeToLive);
                $CI->cachewrapper->add($key, $pizzas, $timeToLive);
            }
        }

        return $pizzas;
    }

    public function save($object) {
        //stub
        return null;
    }

}

/* End of file DbPizzaDao.php */
/* Location: ./application/controllers/DbPizzaDao.php */