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
        $saltedPassword = hash('SHA256',$salt.$password);
        
        //Creating User object for insertion
        $new_user = array(
            'username'  =>  $email,
            'password'  =>  $saltedPassword,
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
    
    public function fetch($id = null, $pass = null)
    {
        return $this->userDao->fetch($id,$pass);
    }

    public function addFavoritePizza($userId=null,$pizzaId=null)
    {
        if($userId !== null && $pizzaId !== null)
        {
            $this->userDao->addFavoritePizza($userId,$pizzaId);
        }
    }

    public function removeFavoritePizza($userId=null,$pizzaId=null)
    {
        if($userId !== null && $pizzaId !== null)
        {
            $this->userDao->removeFavoritePizza($userId,$pizzaId);
        }
    }

    public function getFavorites($userId=null)
    {
        $pizzas = array();
        if($userId !== null)
        {
            $ids = $this->userDao->getFavorites($userId);

            $this->load->model('pizza_model');

            foreach ($ids as $id) {
                $pizzas[] = $this->pizza_model->fetch($id);
            }
        }

        return $pizzas;
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