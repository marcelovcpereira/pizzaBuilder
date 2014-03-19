<?php

require_once 'PizzaEdgeDao.php';
require_once APPPATH . 'models/domain/PizzaEdge.php';

/**
 * Class that persists a PizzaEdge object in a Database.
 * It extends PizzaEdgeDao, so it will implement PizzaEdgeDao's abstract methods:
 * save,fetch and delete. 
 */
class DbPizzaEdgeDao extends PizzaEdgeDao {

    /**
     * The table name!
     */
    private $table = 'edges';
    //ingredients table name
    private $ingredients = 'ingredients';
    //Dry approach to the query creation
    private $idCol = 'id';
    private $nameCol = 'name';
    private $descriptionCol = 'description';
    private $fillingCol = 'filling';
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
    public function fetch($id) {
        //Returned Edge object
        $edge = null;

        //Selects a edge by id
        $query = "SELECT"
                . " e.{$this->idCol}"
                . ",e.{$this->nameCol}"
                . ",e.{$this->descriptionCol}"
                . ",e.{$this->picturePathCol}"
                . ",i.id as fillingId"
                . ",i.name as fillingName"
                . ",i.description as fillingDescription"
                . ",i.picture as fillingPicturePath"
                . " FROM"
                . " {$this->table} e"
                . " LEFT JOIN {$this->ingredients} i"
                . " ON e.{$this->fillingCol} = i.id"
                . " WHERE"
                . " e.{$this->idCol} = ?";

        //Executes the query with the specified prepared statement ($id)
        $result = $this->connection->query($query, array($id));

        //It will only have 0 or 1 results, because it's a search by ID
        //If returns 1, create a new PizzaEdge object
        //Else, keep the null object
        if ($result->num_rows() === 1) {
            //Get the result row
            $row = $result->row();


            //Instantiate a new PizzaEdge
            //and let's initialize it.
            $edge = new PizzaEdge();
            $edge->setId($row->id);
            $edge->setName($row->name);
            $edge->setDescription($row->description);
            $edge->setPicturePath($row->picture);

            //If the edge has filling (filling id is valid)
            if (intval($row->fillingId) !== 0) {
                //Creating the Filling Ingredient
                $filling = new Ingredient();
                $filling->setId($row->fillingId);
                $filling->setName($row->fillingName);
                $filling->setDescription($row->fillingDescription);
                $filling->setPicturePath($row->fillingPicturePath);

                //Adding it to the Edge
                $edge->setFilling($filling);
            }
        }
        return $edge;
    }

    /**
     * Returns all pizza edge records of the database
     * @return type \PizzaEdge[] A list of all pizza edges
     */
    public function fetchAll() {
        //the key value where this query will be cached     
        $key = 'allEdges';
        //5 hours to reset this cache
        $timeToLive = 18000;         
        //Getting code igniter instance
        $CI = & get_instance();
        //Seeking value in CacheWrapper 
        $edges = $CI->cachewrapper->fetch($key);
        if($edges === FALSE)
        {
            //Returned edges List
            $edges = array();
            //Selects all edges
            $query = "SELECT"
                    . " e.{$this->idCol}"
                    . ",e.{$this->nameCol}"
                    . ",e.{$this->descriptionCol}"
                    . ",e.{$this->picturePathCol}"
                    . ",i.id as fillingId"
                    . ",i.name as fillingName"
                    . ",i.description as fillingDescription"
                    . ",i.picture as fillingPicturePath"
                    . " FROM"
                    . " {$this->table} e"
                    . " LEFT JOIN {$this->ingredients} i"
                    . " ON e.{$this->fillingCol} = i.id";

            //Executes the query
            $result = $this->connection->query($query);

            //Checks if there's results
            if ($result->num_rows() > 0) 
            {
                //For each edge found on table
                foreach ($result->result() as $row)
                {
                    //Instantiate a new PizzaEdge
                    //and let's initialize it.
                    $edge = new PizzaEdge();
                    $edge->setId($row->id);
                    $edge->setName($row->name);
                    $edge->setDescription($row->description);
                    $edge->setPicturePath($row->picture);

                    //If the edge has filling (filling id is valid)
                    if (intval($row->fillingId) !== 0) {
                        //Creating the Filling Ingredient
                        $filling = new Ingredient();
                        $filling->setId($row->fillingId);
                        $filling->setName($row->fillingName);
                        $filling->setDescription($row->fillingDescription);
                        $filling->setPicturePath($row->fillingPicturePath);

                        //Adding it to the Edge
                        $edge->setFilling($filling);
                    }

                    //Add to the array
                    $edges[] = $edge;
                }
                /*
                 * Caching the edge types
                 */ 
                $CI->cachewrapper->add($key,$edges,$timeToLive);
            }
        }

        return $edges;
    }

    public function delete($object) {
        //stub
    }

    public function save($object) {
        //stub
    }

}

/* End of file DbPizzaEdgeDao.php */
/* Location: ./application/controllers/DbPizzaEdgeDao.php */