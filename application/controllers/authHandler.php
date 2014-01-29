<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';
require_once APPPATH . 'models/domain/Address.php';
/**
 * This class will be a library to handle user authentication.
 * It can also be an external Authentication framework.
 */
class AuthHandler
{
    //User instance is initialized null
    private $user = null; 
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_loadUser();
    }
    
    /**
     * This method is responsible for initializing the User object.
     * It can load the user info from the session or create an empty
     * user for Visitors of the web app.
     * @return type User the user that is browsing the application
     */
    private function _loadUser()
    {
        //Getting User information in session 
        $user = $this->session->userdata('user');
        
        //If there's no User, let's create a Visitor profile
        if ($user === FALSE)
        {
            $user = new User();
            $user->setName("Visitor");
            
        }
        //If the User is connected, let's create it from session
        else
        {
            $user = $this->_createUserFromSession();
        }
        //Sets the user
        $this->_setUser($user);
    }
    
    public function _setUser(User $user)
    {
        if($user !== null){
            $this->user = $user;
        }
        
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    private function _createUserFromSession()
    {
        //stub
    }
    
}


/* End of file authHandler.php */
/* Location: ./application/controllers/authHandler.php */