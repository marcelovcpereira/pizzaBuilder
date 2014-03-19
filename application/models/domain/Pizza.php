<?php
require_once 'PizzaFlavor.php';
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

class Pizza implements JsonSerializable{
    
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
    //The list of flavors of this pizza
    private $flavors;
    //Type of pizza ('user' or 'system')
    private $type;
    
    public function __construct()
    {
        $this->setName("");
        $this->setDescription("");
        $this->setObservations("");
        $this->setPicturePath("");
        $this->setCrust();
        $this->setEdge();
        $this->setLayout();
        $this->setSize();
        $this->flavors = array();
        $this->type = 'user';        
    }

    public function getFlavors()
    {
        return $this->flavors;
    }
    
    public function getPicturePath() 
    {
        return $this->picturePath;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPicturePath($picturePath) 
    {
        $this->picturePath = $picturePath;
    }

        
    public function getName() 
    {
        return $this->name;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function getEdge() 
    {
        return $this->edge;
    }

    public function getLayout() 
    {
        return $this->layout;
    }

    public function getSize() 
    {
        return $this->size;
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setFlavors(array $flavors)
    {
        if(count($flavors) > 0)
        {
            $this->flavors = array_merge($this->flavors, $flavors);
        }
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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setEdge(PizzaEdge $edge = null)
    {
        $this->edge = $edge;
    }

    public function setLayout(PizzaLayout $layout = null)
    {
        $this->layout = $layout;
    }

    public function setSize(PizzaSize $size = null)
    {
        $this->size = $size;
    }

    public function setObservations($observations)
    {
        $this->observations = $observations;
    }

    public function getCrust() {
        return $this->crust;
    }

    public function setCrust(PizzaCrust $crust = null)
    {
        $this->crust = $crust;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function __toString()
    {
        return json_encode($this);
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
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
    
    public function addFlavor(Flavor $flavor)
    {
        if($flavor != null)
        {
            $this->flavors[] = flavor;
        }
    }


}

/* End of file Pizza.php */
/* Location: ./application/controllers/Pizza.php */