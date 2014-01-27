<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';
require_once APPPATH . 'models/domain/Address.php';

class AuthHandler extends CI_Controller
{
    //User instance is initialized null
    private $user = null; 
    
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_loadUser();
    }
    
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
            //$user = $this->_createUserFromSession();
        }
    }
    
    private function _createUserFromSession()
    {
        
    }
    
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */