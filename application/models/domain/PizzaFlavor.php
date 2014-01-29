<?php
require_once 'Ingredient.php';
/*
 * This class represents a PizzaFlavor entity of the
 * application. A flavor is made up of a list of Ingredients
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PizzaFlavor {
    
    //flavor id
    private $id;
    //The Flavor name.
    private $name;
    //The Flavor description.
    private $description;
    //The path to the picture of this Flavor!
    private $picturePath;
    //The ingredients that compounds this flavor
    private $ingredients;
    
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setPicturePath("");
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

        
    public function getIngredients() {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients) {
        $this->ingredients = $ingredients;
    }

        
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPicturePath() {
        return $this->picturePath;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

    public function __toString() {
        $string = "|Flavor:";
        $string .= $this->getName() . ",<br>"
                . $this->getDescription() . ",<br>"
                . $this->getPicturePath() . "|";
        return $string;
    }

}

/* End of file PizzaFlavor.php */
/* Location: ./application/controllers/PizzaFlavor.php */