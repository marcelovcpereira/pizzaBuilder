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

    public function getEdges() {
        return $this->edges;
    }

    public function getLayouts() {
        return $this->layouts;
    }

    public function getFlavors() {
        return $this->flavors;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function setCrusts($crust = array()) {
        $this->crusts = $crust;
    }

    public function setSizes($size = array()) {
        $this->sizes = $size;
    }

    public function setEdges($edge = array()) {
        $this->edges = $edge;
    }

    public function setLayouts($layout = array()) {
        $this->layouts = $layout;
    }

    public function setFlavors($flavor = array()) {
        $this->flavors = $flavor;
    }

    public function setIngredients($ingredient = array()) {
        $this->ingredients = $ingredient;
    }

    public function __toString() {
        $string = "";

        foreach ($this->crusts as $crust) {
            $string .= "Crust: " . $crust->getName() . "<br>" . $crust->getDescription() . "<br>";
        }
        foreach ($this->sizes as $size) {
            $string .= "Size: " . $size->getName() . "<br>" . $size->getDescription() . "<br>";
        }
        foreach ($this->layouts as $layout) {
            $string .= "Layout: " . $layout->getName() . "<br>" . $layout->getDescription() . "<br>";
        }
        foreach ($this->edges as $edge) {
            $string .= "Edge: " . $edge->getName() . "<br>" . $edge->getDescription() . "<br>";
        }
        foreach ($this->flavors as $flavor) {
            $string .= "Flavor: " . $flavor->getName() . "<br>" . $flavor->getDescription() . "<br>";
        }
        foreach ($this->ingredients as $ingredient) {
            $string .= "Ingredient: " . $ingredient->getName() . "<br>" . $ingredient->getDescription() . "<br>";
        }
        return $string;
    }

    public function getSizes() {
        return $this->sizes;
    }

}

/* End of file PizzaBuilderDomain.php */
/* Location: ./application/domain/PizzaBuilderDomain.php */