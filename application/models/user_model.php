<?php
require_once APPPATH . '/models/domain/User.php';
require_once APPPATH . '/models/dao/DBUserDao.php';
/**
 * Model representation of the Users Entity. 
 * This class manipulates the User persistance via a UserDao Object.
 * In this case it uses a DbUserDao Object (to access a database persistance layer)
 * This class keeps messages (status and errors) in an array, and can be passed
 * by the controller to the view
 */
class User_model extends CI_Model 
{
    //Array of status and error messages
    private $messages = array();
    
    //Model Parameters
    
    //Table name in the database
    private $table = 'user';
    
    //Salt column name in the database
    private $salt_column = 'salt';    
    
    //Mysql SHA2 Parameter
    //indicates the version of SHA algorithm
    //224, 256, 384, 512, or 0 (which is equivalent to 256)
    private $sha_algorithm = '256';
    
    //UserDao for User class
    private $userDao;
    
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->userDao = new DbUserDao($this->db);
    }
    
    //returns the Messages Array
    public function get_messages(){
        return $this->messages;
    }
    
    /**
     * Searches for username and password in the database.
     * Returns user if there's a match and empty array if not
     * Uses common SQL Query
     * @param type $username
     * @param type $password
     * @return int User object (array) from searched user or empty array
     * if not found
     */
    public function login($username,$password)
    {    
        $user = array();
        
        $query = "SELECT id,name,last_name FROM {$this->table} "
        . "WHERE username = '{$username}' AND "
        . "password = SHA2(CONCAT({$this->table}.{$this->salt_column},'{$password}'),{$this->sha_algorithm})";
        
        //Looking for user in database... 
        //This model uses a SALT concatenated before the pass
        //example: PASS: 123, SALT:1 , saltedpass: 1123
        //This model uses SHA256 as hashing function        
        $result = $this->db->query($query);       
       
        //If there's any result -> Success
        if ($result->num_rows() > 0)
        {   
            $this->messages['status'] = 'Successfull Login';
            
            $user = array(
                'id' => $result->row()->id,
                'name' => $result->row()->name,
                'last_name' => $result->row()->id,
                'username' => $username
            );            
        }else
        {
            $this->messages['status'] = 'Unsuccessfull Login';
            $this->messages['error'] = 'Invalid username or incorrect password.';            
        }
        return $user;
        
        
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
     * Searches and returns an User object by it's id
     * @param type int $id id of the user to be fetched
     * @return type User 
     */
    public function fetch_tmp($id=null)
    {        
        $this->load->model('address_model');
        
        //this function will return a null User if there's something wrong
        $user = null;
        
        //If there's no valid $id passed as argument, return empty
        if ($id !== null)
        {        
            //get all user columns
            $result = $this->db->get_where($this->table,array('id'=>$id));
            
            //If the search brings results, lets 
            if ($result->num_rows() > 0)
            {
                //Getting the returned table row
                $row = $result->row();
                
                //Creating the User instance
                $user = new User();
                $user->setId($row->id);
                $user->setUsername($row->username);
                $user->setName($row->name);
                $user->setLastName($row->last_name);
                $user->setPassword($row->password);
                $user->setSalt($row->salt);
                
                /**
                 * Searching for the user address.
                 * Returns a null address if not found.
                 */                
                $address = $this->address_model->fetch($row->address_id);
                
                //Setting the address to the user
                $user->setAddress($address);                
            }
        }
        return $user;
    }
    
    public function fetch($id = null, $pass = null)
    {
        return $this->userDao->fetch($id,$pass);
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