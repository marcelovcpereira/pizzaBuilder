<?php

/**
 * Model representation of the Property Entity.
 * This class manipulates the table 'property'. (to change it, modify the table attribute)
 * This class keeps messages (status and errors) in an array, and can be passed
 * by the controller to the view
 */
class Property_model extends CI_Model 
{
    
    //Array of status and error messages
    private $messages = array();
    
    //Model Parameters
    
    //Table name in the database
    private $table = 'property';
    
    //Property status ignored by the search routine
    private $ignoredProperties = 'Closed';
    
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //returns the Messages Array
    public function get_messages(){
        return $this->messages;
    }
    
    public function searchProperty($data)
    {
        if ($data !== array())
        {
            $query = "SELECT * FROM {$this->table} WHERE ";
            if (isset($data['location']))
            {
                $query = $query . "location = '?'";
            }
        }
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
        
        //Remove Closed properties 
        $index = array_search($this->ignoredProperties,$enum);
        if ($index)
        {
            unset($enum[$index]);
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
     * Adds a new user to the USERS table
     * 
     * @param type $name
     * @param type $last_name
     * @param type $email
     * @param type $password
     */
    public function add_user($name,$last_name,$email,$password,$addr_id="")
    {
        //Salt is a MD5 hash of a random 10-length number
        $salt = md5($this->generate_random_salt());
        
        //Password is a SHA-256 hash of SALT + PLAIN PASSWORD
        $password = hash('SHA256',$salt.$password);
        
        //Creating User object for insertion
        $new_user = array(
            'username'  =>  $email,
            'password'  =>  $password,
            'salt'      =>  $salt,
            'name'      =>  $name,
            'last_name' =>  $last_name,
            'address_id' => $addr_id
        );
        
        //Calling Codeigniter ActiveRecord Object for safer insertion
        $inserted = $this->db->insert('user',$new_user);
        if ($inserted)
        {
            $this->messages['status'] = 'User successfully added to the database';
        }
        else
        {
            $this->message['error'] = "Failed to add new user: " . $this->db->_error_message();
        }
    }

    /**
     * Searches the database for an user with a given ID
     * @param type $id
     * @return type
     */
    public function get_user_by_id($id=-1)
    {
        $user = array();
        
        //If there's no ID passed as argument, return empty
        if ($id !== -1)
        {        
            //get all user columns, we must change that to what we actually need to load
            $result = $this->db->get_where('user',array('id'=>$id));
            
            if ($result->num_rows() > 0)
            {
                $row = $result->row();
                
                //Quering user ADDRESS
                $address = $this->get_user_address($row->id);
                /*
                 * Creating an object of the found user
                 */
                $user = array(
                    'user_id' => $row->id,
                    'username' => $row->username,
                    'name'      =>  $row->name,
                    'last_name' =>  $row->last_name,
                    'address' => $address
                );
                
            }
        }
        return $user;
    }
    
    public function get_user_address($id=-1)
    {
        $address = array();
        
        if ($id !== -1)
        {
            $address_id = $this->get_address_id($id);
            
            //ACCESSING ANOTHER MODEL 
            $address = $this->address_model->get_address($address_id);
        }
        
        return $address;
    }
    
    public function get_address_id($user_id)
    {
        $address_id = -1;
        
        $this->db->select('address_id');
        $result = $this->db->get_where('user', array('id'=>$user_id ));
        
        if ($result->num_rows() === 1)
        {
            $address_id = $result->row()->address_id;
        }
        
        return $address_id;
    }
    
    /**
     * Generates a random alpha-numeric String.
     * @param type $length length of the returned random string
     * @return string
     */
    private function generate_random_salt($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */