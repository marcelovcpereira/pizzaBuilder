<?php
require_once APPPATH . 'models/domain/Address.php';
/**
 * Model representation of the Users Entity.
 * This class manipulates the table 'user'. (to change it, modify the table attribute)
 * This class keeps messages (status and errors) in an array, and can be passed
 * by the controller to the view
 */
class Address_model extends CI_Model 
{
    private $table = 'address';
     
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    public function fetch($id=null)
    {
       $address = null;
        //If ID is valid
        if ($id !== null)
        {
            //querying for the address with the given $id
            $result = $this->db->get_where($this->table, array('id' => $id) );
            
            //is there only one result?
            //this is a id search, should return 0 or 1 result
            if ($result->num_rows() === 1)
            {
                $row = $result->row();
                
                //Creating an Address instance
                $address = new Address();
                $address->setId($row->id);
                $address->setName($row->name);
                $address->setType($row->type);
                $address->setNumber($row->number);
                $address->setAdditionalInfo($row->additional);
                $address->setCity($row->city);
                $address->setState($row->state);
                $address->setCountry($row->country);
                $address->setPostalCode($row->postal_code);
            }
        }
        return $address; 
    }
    
    public function get_address($id=-1)
    {
        $address = array();
        //If ID is given
        if ($id !== -1)
        {
            $result = $this->db->get_where('address', array('id' => $id) );
            if ($result->num_rows() === 1)
            {
                $row = $result->row();
                $address = array(
                    'name'  =>  $row->name,
                    'type'  =>  $row->type,
                    'number'    =>  $row->number,
                    'additional'    =>  $row->additional,
                    'city'  =>  $row->city,
                    'state' =>  $row->state,
                    'country' =>    $row->country,
                    'postal_code'    =>  $row->postal_code
                );
            }
        }
        return $address;
    }
   
    /**
     * Inserts a new Addres object in the database. 
     * Returns the id of the inserted value, -1 if invalid enum, -2 other insertion error
     * @param type $name
     * @param type $type
     * @param type $number
     * @param type $addition
     * @param type $city
     * @param type $state
     * @param type $country
     * @param type $postal_code
     * @return type INTEGER The ID of the new inserted row. -1 if Enum is 
     * invalid, -2 other errors
     */
    public function add_address($name,$type,$number,$addition,$city,$state,$country,$postal_code)    
    {   
        $return_code = -1;
        //checking if the address type is a valid type
        if ($this->is_valid_enum($type, 'address', 'type'))
        {
            //creating the object
            $address = array(
                'name' => $name,
                'type' => $type ,
                'number' => $number,
                'additional' => $addition,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postal_code' => $postal_code
            );
            //Trying to insert...
            $inserted = $this->db->insert('address', $address);
            if ($inserted)
            {
                //getting the response code
                $return_code = $this->db->insert_id();
            }else{
                $return_code = -2;
            }
        }
        
        return $return_code;
    }
    
    /**
     * Returns an array containing all the possible values of an enum column
     * @param type $table table where there's an enum field
     * @param type $field name of the enum field
     * @return array all possible enum values
     */
    function get_enum_values( $table, $field )
    {
        //Selecting the definition code (SQL) of the field
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        foreach( explode(',', $matches[1]) as $value )
        {
             $enum[] = trim( $value, "'" );
        }
        return $enum;
    }
    
    /**
     * Returns an associative array for the enum values.
     * Ex: if the values are "Red" and "Blue", this will return:
     * array("Red" => "Red", "Blue" => "Blue");
     * @param type $table
     * @param type $field
     * @return type
     */
    function get_dropdown_enum( $table, $field )
    {        
        $return_array = array();
        $values = $this->get_enum_values($table, $field);
        
        foreach ($values as $value)
        {
            $return_array[$value] = $value;
        }
        
        return $return_array;
    }
    
    /**
     * Utility function used to parse Full Address name, eg Street, Avenue,etc
     * into a abbreviation, eg St, Av, etc
     * @param type $value
     * @return string
     */
    public function get_short_enum($value)
    {
        $return = '';
        switch ($value)
        {
            case 'Street': $return = 'St.'; break;
            case 'Avenue': $return = "Av."; break;
            case 'Boulevard': $return = 'Bl.'; break;                
        }        
        return $return;
    }
    
    /**
     * Checks if the given value if valid for some ENUM table field
     * @param type $value
     * @param type $table
     * @param type $field
     * @return type
     */
    function is_valid_enum($value, $table, $field)
    {
        //selects all the possible values for this ENUM
        $possible = $this->get_enum_values($table, $field);
        
        //Checks if the given value is a valid possibly value for this field
        return in_array($value,$possible);
    }
            
}
/* End of file address_model.php */
/* Location: ./application/models/address_model.php */