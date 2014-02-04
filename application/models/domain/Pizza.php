<?php

require_once 'PizzaCrust.php';
/*
 * This class represents a Pizza entity of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Pizza {
    
    //pizza id
    private $id;
    //pizza name
    private $name;
    //pizza description
    private $description;
    //The user especial observations to the pizza chef!
    private $observations;
    //The pizza picture
    private $picturePath;
    //The pizza crust object.
    private $crust;
    //The pizza edge object.
    private $edge;
    //The pizza layout object.
    private $layout;
    //The pizza size object
    private $size;
    //The four pizza flavors (only flavor1 not nullable
    private $flavor1;
    private $flavor2;
    private $flavor3;
    private $flavor4;
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setObservations("");
        $this->setPicturePath("");
        $this->setCrust();
        $this->setEdge();
        $this->setFlavor1();
        $this->setFlavor2();
        $this->setFlavor3();
        $this->setFlavor4();
        $this->setLayout();
        $this->setSize();
        
    }
    
    public function getPicturePath() {
        return $this->picturePath;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

        
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getEdge() {
        return $this->edge;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function getSize() {
        return $this->size;
    }

    public function getFlavor1() {
        return $this->flavor1;
    }

    public function getFlavor2() {
        return $this->flavor2;
    }

    public function getFlavor3() {
        return $this->flavor3;
    }

    public function getFlavor4() {
        return $this->flavor4;
    }

    public function getObservations() {
        return $this->observations;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setEdge(PizzaEdge $edge = null) {
        $this->edge = $edge;
    }

    public function setLayout(PizzaLayout $layout = null) {
        $this->layout = $layout;
    }

    public function setSize(PizzaSize $size = null) {
        $this->size = $size;
    }

    public function setFlavor1(PizzaFlavor $flavor1 = null) {
        $this->flavor1 = $flavor1;
    }

    public function setFlavor2(PizzaFlavor $flavor2 = null) {
        $this->flavor2 = $flavor2;
    }

    public function setFlavor3(PizzaFlavor $flavor3 = null) {
        $this->flavor3 = $flavor3;
    }

    public function setFlavor4(PizzaFlavor $flavor4 = null) {
        $this->flavor4 = $flavor4;
    }

    public function setObservations($observations) {
        $this->observations = $observations;
    }

    public function getCrust() {
        return $this->crust;
    }

    public function setCrust(PizzaCrust $crust = null) {
        $this->crust = $crust;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function __toString() {
        $string = "Pizza: " . $this->getId() . "<br>";
        $string .= "-----------------------------<br>";
        $string .= $this->getName() . "<br>";
        $string .= "-----------------------------<br>";
        $string .= $this->getDescription() . "<br>";
        $string .= "-----------------------------<br>";
        $string .= $this->getObservations() . "<br>";
        $string .= "-----------------------------<br>";
        $string .= $this->getPicturePath() . "<br>";
        $string .= "-----------------------------<br>";
        $string .= $this->getCrust();
        $string .= $this->getEdge();
        $string .= $this->getLayout();
        $string .= $this->getSize();
        $string .= $this->getFlavor1();
        $string .= $this->getFlavor2();
        $string .= $this->getFlavor3();
        $string .= $this->getFlavor4();
        return $string;
    }
    
    public function getRecipe()
    {
        $recipe = "";
        $ingredients1 = $this->getFlavor1()->getIngredients();
        foreach($ingredients1 as $ingredient)
        {
            $recipe .= $ingredient->getName() . ",";
        }
        $recipe = substr($recipe,0,  strlen($recipe)-1 );
        return $recipe;
    }
    
    /**
     * Return all flavors as an array
     * @return type PizzaFlavor[] array of flavors of this pizza
     */
    public function getFlavors()
    {
        $return = array();
        
        if($this->flavor1 !== null){
            $return[] = $this->flavor1;
        }
        
        if($this->flavor2 !== null){
            $return[] = $this->flavor2;
        }
        
        if($this->flavor3 !== null){
            $return[] = $this->flavor3;
        }
        
        if($this->flavor4 !== null){
            $return[] = $this->flavor4;
        }
        
        return $return;
       
    }


}

/* End of file Pizza.php */
/* Location: ./application/controllers/Pizza.php */