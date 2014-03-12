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
        
        $flavors = array();
        /* Foreach flavor, create a PizzaFlavor object and insert Ingredient
         * objects */
        foreach($jsonPizza->flavors as $flavor)
        {
            $flavorObj = new PizzaFlavor();
            $flavorObj->setId($flavor->id);
            $flavorObj->setName($flavor->name);
            $flavorObj->setDescription($flavor->description);
            $flavorObj->setPicturePath($flavor->picturePath);

            $ingredients = array();
            foreach($flavor->ingredients as $ingredient)
            {
                $ingredients[] = new Ingredient($ingredient->id,$ingredient->name,$ingredient->description,$ingredient->picturePath);
            }
            $flavorObj->setIngredients($ingredients);

            $flavors[] = $flavorObj;
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
        $pizza->setFlavors($flavors);
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