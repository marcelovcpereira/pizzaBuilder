<?php

/*
 * This class represents a PizzaLayout entity of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PizzaLayout implements JsonSerializable
{

    //layout id
    private $id;
    //The pizza layout name.
    private $name;
    //The layout description.
    private $description;
    //The layout pattern
    private $pattern;    
    //The path to the picture of this size!
    private $picturePath;
    
        
    public function __construct()
    {
        $this->setName("");
        $this->setPattern("8");
        $this->setDescription("");
        $this->setPicturePath("");
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

        
    public function getPattern() {
        return $this->pattern;
    }

    public function setPattern($pattern) {        
        $this->pattern = $pattern;
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

    public function __toString()
    {
        return json_encode($this);
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }

}

/* End of file PizzaLayout.php */
/* Location: ./application/controllers/PizzaLayout.php */