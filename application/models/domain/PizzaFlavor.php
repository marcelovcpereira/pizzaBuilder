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

class PizzaFlavor implements JsonSerializable{
    
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
    //Type of flavor ('user' or 'system')
    private $type;
    
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setPicturePath("");
        $this->ingredients = array();
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

    public function getType()
    {
        return $this->type;
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

    public function setType($type)
    {
        switch($type)
        {
            case 'user':
                $this->type = 'user';
                break;
            case 'system':
            default:
                $this->type = 'system';
                break;
        }
    }

    public function __toString() {
       return json_encode($this);
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }

}

/* End of file PizzaFlavor.php */
/* Location: ./application/controllers/PizzaFlavor.php */