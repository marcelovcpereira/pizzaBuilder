<?php

/* 
 * This class represents a persistent Address Object.
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Address
{
    /**
     *
     * @var type int id of the address
     */
    private $id;  
    
    /**
     *
     * @var type String address
     */
    private $name;
    
    /**
     * Represents the type of the address. 
     * Next improvement: Create a AddressType Object
     * @var type Enum ('Street','Avenue','Boulevard')
     */
    private $type;
    
    /**
     *
     * @var type int number of the address
     */
    private $number;
    
    /**
     *
     * @var type String additional information about the address
     * (ex: references)
     */
    private $additionalInfo;
    
    /**
     * Next improvement: Create a table of cities
     * @var type String name of the city
     */
    private $city;
    
    /**
     * Next improvement: Create a table of states
     * @var type String name of the state
     */
    private $state;
    
    /**
     * Next improvement: Create a table of countries
     * @var type String country name
     */
    private $country;
    
    /**
     * Zip or postal code for the address
     * @var type String zip / postal code
     */
    private $postalCode;
    
    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getAdditionalInfo() {
        return $this->additionalInfo;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function setAdditionalInfo($additionalInfo) {
        $this->additionalInfo = $additionalInfo;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }


}
/* End of file Address.php */
/* Location: ./application/controllers/Address.php */