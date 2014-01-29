<?php

/*
 * This class represents a PizzaCrust entity of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PizzaCrust {

    //crust id
    private $id;
    //The pizza crust name.
    private $name;
    //The crust description.
    private $description;
    //The path to the picture of this crust!
    private $picturePath;
    
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
        $string = "|Crust:";
        $string .= $this->getName() . ",<br>"
                . $this->getDescription() . ",<br>"
                . $this->getPicturePath() . "|";
        return $string;
    }

}

/* End of file PizzaCrust.php */
/* Location: ./application/controllers/PizzaCrust.php */