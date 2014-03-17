<?php 
/* 
 * This class represents a persistent User of the
 * application. 
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class User implements JsonSerializable
{
    /**
     *
     * @var type int Numeric table $id
     */
    private $id;
    /**
     * @var type String the logical identifier of the user
     */
    private $username;
    
    /**
     *
     * @var type String the user hashed password: hash(hash(salt).password)
     */
    private $password;
    
    /**
     *
     * @var type String the hashed salt of the password
     */
    private $salt;
    
    /**
     *
     * @var type String Name of the user
     */
    private $name;
    
    /**
     *
     * @var type String Last Name/Family Name of the user
     */
    private $lastName;
    
    /**
     *
     * @var type Address (Object) of the user (can be null)
     */
    private $address;

    /**
     *
     * @var type Array of pizza Id (can be empty)
     */
    private $favorites;
    
    /**
     * Constructor of User class.     
     * @param type $id
     */
    public function __construct($id=null)
    {
        $this->setId($id);
        $this->setUsername("");
        $this->setName("");
        $this->setLastName("");
        $this->setAddress(null);
        $this->setPassword("");
        $this->setSalt("");
        $this->favorites = array();
    }
    
    /**
     * 
     * @return type int id of the user
     */
    public function getId()
    {
        return $this->id;
    }   

    public function getFavorites()
    {
        return $this->favorites;
    }

    
    /**
     * 
     * @return type String name of the user
     */
    public function getUsername() 
    {
        return $this->username;
    }

    /**
     * 
     * @return type String hashed password of the user
     */
    public function getPassword() 
    {
        return $this->password;
    }

    /**
     * 
     * @return type String hashed salt of the password
     */
    public function getSalt() 
    {
        return $this->salt;
    }

    /**
     * 
     * @return type String the first name of the user
     */
    public function getName() 
    {
        return $this->name;
    }

    /**
     * 
     * @return type String the family/last name of the user
     */
    public function getLastName() 
    {
        return $this->lastName;
    }

    /**
     * 
     * @return type Address the user's address info 
     */
    public function getAddress() 
    {
        return $this->address;
    }
    
    /**
     * 
     * @param int $id table id of the User
     */
    public function setId($id=null)
    {
        if ($id !== null)
        {
            $this->id = $id;
        }
    }

    /**
     * 
     * @param String $username
     */
    public function setUsername($username) 
    {
        $this->username = $username;
    }

    /**
     * 
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * 
     * @param String $salt
     */
    public function setSalt($salt) 
    {
        $this->salt = $salt;
    }

    /**
     * 
     * @param String $name
     */
    public function setName($name) 
    {
        $this->name = $name;
    }

    /**
     * 
     * @param String $lastName
     */
    public function setLastName($lastName) 
    {
        $this->lastName = $lastName;
    }

    /**
     * 
     * @param String $address
     */
    public function setAddress($address) 
    {
        $this->address = $address;
    }

    public function setFavorites(array $favs)
    {
        $this->favorites = $favs;
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }

    public function __toString()
    {
        return json_encode($this);
    }

    public function isFavorite(Pizza $pizza)
    {
        return in_array($pizza->getId(),$this->getFavorites());
    }

    public function addFavorite($id)
    {
        $this->favorites[] = $id;
    }

    public function removeFavorite($id)
    {
        $index = array_search($id,$this->favorites);
        if(FALSE !== $index)
        {
          unset($this->favorites[$index]);  
        } 
    }
}
/* End of file User.php */
/* Location: ./application/controllers/User.php */