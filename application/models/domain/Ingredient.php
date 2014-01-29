<?php

/*
 * This class represents a Ingredient entity of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Ingredient {

    //The Ingredient name.
    private $name;
    //The Ingredient description.
    private $description;
    //The path to the picture of this Ingredient!
    private $picturePath;
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setPicturePath("");
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
        $string = "|Ingredient:";
        $string .= $this->getName() . ",<br>"
                . $this->getDescription() . ",<br>"
                . $this->getPicturePath() . "|";
        return $string;
    }

}

/* End of file Ingredient.php */
/* Location: ./application/controllers/Ingredient.php */