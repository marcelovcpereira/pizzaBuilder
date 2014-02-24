<?php
require_once 'Ingredient.php';
/*
 * This class represents a PizzaEdge entity of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PizzaEdge implements JsonSerializable
{
    //edge id
    private $id;
    //The pizza edge name.
    private $name;
    //The edge description.
    private $description;
    //The filling of the edge
    private $filling;
    //The path to the picture of this edge!
    private $picturePath;
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setFilling(null);
        $this->setPicturePath("");
    }
    
    public function getFilling() 
    {
        return $this->filling;
    }

    public function setFilling(Ingredient $filling = null)
    {
        $this->filling = $filling;
    }

        
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

        
    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPicturePath()
    {
        return $this->picturePath;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPicturePath($picturePath)
    {
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

/* End of file PizzaEdge.php */
/* Location: ./application/controllers/PizzaEdge.php */