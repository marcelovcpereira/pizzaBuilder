<?php

/*
 * This class represents a PizzaBuilder Object.
 * The PizzaBuilder is not a persistent entity, but it's made of
 * various persistant objects. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PizzaBuilderDomain {

    //Available crusts
    private $crusts;
    //Available edges
    private $edges;
    //Available sizes
    private $sizes;
    //Available layouts
    private $layouts;
    //Available flavors
    private $flavors;
    //Available ingredients
    private $ingredients;

    public function __construct() {
        $this->setCrusts();
        $this->setEdges();
        $this->setSizes();
        $this->setLayouts();
        $this->setFlavors();
        $this->setIngredients();
    }

    public function getCrusts() {
        return $this->crusts;
    }

    public function getEdges() 
    {
        return $this->edges;
    }

    public function getLayouts() 
    {
        return $this->layouts;
    }

    public function getFlavors() 
    {
        return $this->flavors;
    }

    public function getIngredients() 
    {
        return $this->ingredients;
    }

    public function setCrusts($crust = array()) 
    {
        $this->crusts = $crust;
    }

    public function setSizes($size = array()) 
    {
        $this->sizes = $size;
    }

    public function setEdges($edge = array()) 
    {
        $this->edges = $edge;
    }

    public function setLayouts($layout = array()) 
    {
        $this->layouts = $layout;
    }

    public function setFlavors($flavor = array()) 
    {
        $this->flavors = $flavor;
    }

    public function setIngredients($ingredient = array()) 
    {
        $this->ingredients = $ingredient;
    }

    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Receives a JSON representation of a pizza object:
     * {sizeId,crustId,edgeId,layoutId,flavor1,flavor2,flavor3,flavor4,observations}
     * and returns an actual Pizza Object instance.
     */
    public function getPizzaByJSON($jsonPizza)
    {
        //Get PizzaSize object by id
        $size = $this->findSize($jsonPizza->sizeId);
        //Get PizzaCrust object by id
        $crust = $this->findCrust($jsonPizza->crustId);
        //Get PizzaEdge object by id
        $edge = $this->findEdge($jsonPizza->edgeId);
        //Get PizzaLayout object by id
        $layout = $this->findLayout($jsonPizza->layoutId);

        //Get Flavors if they are setted, null otherwise
        $flavor1 = isset($jsonPizza->flavors[0]) ? $jsonPizza->flavors[0] : null;
        $flavor2 = isset($jsonPizza->flavors[1]) ? $jsonPizza->flavors[1] : null;
        $flavor3 = isset($jsonPizza->flavors[2]) ? $jsonPizza->flavors[2] : null;
        $flavor4 = isset($jsonPizza->flavors[3]) ? $jsonPizza->flavors[3] : null;
        
        /* If flavor1 is valid, lets parse it to PizzaFlavor Object */
        if($flavor1)
        {
            $flavor1Obj = new PizzaFlavor();
            $flavor1Obj->setId($flavor1->id);
            $flavor1Obj->setName($flavor1->name);
            $flavor1Obj->setDescription($flavor1->description);
            $flavor1Obj->setPicturePath($flavor1->picturePath);

            /* Parsing all json ingredients to actual Ingredients instances */
            $ingredients = array();            
            foreach($flavor1->ingredients as $ingredient)
            {                
                $ingredients[] = new Ingredient($ingredient->id,$ingredient->name,$ingredient->description,$ingredient->picturePath);
            }
            $flavor1Obj->setIngredients($ingredients);

            $flavor1 = $flavor1Obj;
        }
        /* If flavor2 is valid, lets parse it to PizzaFlavor Object */
        if($flavor2)
        {
            $flavor2Obj = new PizzaFlavor();
            $flavor2Obj->setId($flavor2->id);
            $flavor2Obj->setName($flavor2->name);
            $flavor2Obj->setDescription($flavor2->description);
            $flavor2Obj->setPicturePath($flavor2->picturePath);

            $ingredients = array();
            foreach($flavor2->ingredients as $ingredient)
            {
                $ingredients[] = new Ingredient($ingredient->id,$ingredient->name,$ingredient->description,$ingredient->picturePath);
            }
            $flavor2Obj->setIngredients($ingredients);

            $flavor2 = $flavor2Obj;
        }
        /* If flavor3 is valid, lets parse it to PizzaFlavor Object */
        if($flavor3)
        {
            $flavor3Obj = new PizzaFlavor();
            $flavor3Obj->setId($flavor3->id);
            $flavor3Obj->setName($flavor3->name);
            $flavor3Obj->setDescription($flavor3->description);
            $flavor3Obj->setPicturePath($flavor3->picturePath);

            $ingredients = array();
            foreach($flavor3->ingredients as $ingredient)
            {
                $ingredients[] = new Ingredient($ingredient->id,$ingredient->name,$ingredient->description,$ingredient->picturePath);
            }
            $flavor3Obj->setIngredients($ingredients);

            $flavor3 = $flavor3Obj;
        }
        /* If flavor4 is valid, lets parse it to PizzaFlavor Object */
        if($flavor4)
        {
            $flavor4Obj = new PizzaFlavor();
            $flavor4Obj->setId($flavor4->id);
            $flavor4Obj->setName($flavor4->name);
            $flavor4Obj->setDescription($flavor4->description);
            $flavor4Obj->setPicturePath($flavor4->picturePath);

            $ingredients = array();
            foreach($flavor4->ingredients as $ingredient)
            {
                $ingredients[] = new Ingredient($ingredient->id,$ingredient->name,$ingredient->description,$ingredient->picturePath);
            }
            $flavor4Obj->setIngredients($ingredients);

            $flavor4 = $flavor4Obj;
        }         
        
        /* Creating and returning the pizza */
        $pizza = new Pizza();
        $pizza->setId($jsonPizza->id);
        $pizza->setName($jsonPizza->name);
        $pizza->setDescription($jsonPizza->description);
        $pizza->setPicturePath($jsonPizza->picturePath);
        $pizza->setSize($size);
        $pizza->setCrust($crust);
        $pizza->setEdge($edge);
        $pizza->setLayout($layout);
        $pizza->setflavor1($flavor1);
        $pizza->setflavor2($flavor2);
        $pizza->setflavor3($flavor3);
        $pizza->setflavor4($flavor4);
        $pizza->setObservations($jsonPizza->observation);
        return $pizza;
    }

    /**
     * Searchs the array of PizzaSize for the 
     * size with given $id
     */
    public function findSize($id){
        $foundSize = null;
        foreach($this->sizes as $size){
            if($size->getId() == $id){
                $foundSize = $size;
                break;
            }
        }
        return $foundSize;
    }

    /**
     * Searchs the array of PizzaCrust for the 
     * Crust with given $id
     */
    public function findCrust($id){
        $foundCrust = null;
        foreach($this->crusts as $crust){
            if($crust->getId() == $id){
                $foundCrust = $crust;
                break;
            }
        }
        return $foundCrust;
    }

    /**
     * Searchs the array of PizzaEdge for the 
     * Edge with given $id
     */
    public function findEdge($id){
        $foundEdge = null;
        foreach($this->edges as $edge){
            if($edge->getId() == $id){
                $foundEdge = $edge;
                break;
            }
        }
        return $foundEdge;
    }

     /**
     * Searchs the array of PizzaLayout for the 
     * Layout with given $id
     */
    public function findLayout($id){
        $foundLayout = null;
        foreach($this->layouts as $layout){
            if($layout->getId() == $id){
                $foundLayout = $layout;
                break;
            }
        }
        return $foundLayout;
    }

    /**
     * Searchs the array of PizzaFlavor for the 
     * Flavor with given $id
     */
    public function findFlavor($id){
        $foundFlavor = null;
        foreach($this->flavors as $flavor){
            if($flavor->getId() == $id){
                $foundflavor = $flavor;
                break;
            }
        }
        return $foundFlavor;
    }

}

/* End of file PizzaBuilderDomain.php */
/* Location: ./application/domain/PizzaBuilderDomain.php */