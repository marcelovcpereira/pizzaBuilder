<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';
require_once APPPATH . 'models/domain/Address.php';


class Portal extends CI_Controller
{
    /**
     * Default page of the portal, redirects to Home
     */
    public function index()
    {
        //stub
	//$auth = new AuthHandler();
        //$user = $auth->getUser();
        $user = null;
        $data = array(
            'page'=>'home_view', //that's where we're going
            'user' => $user     //that's the user who is here
        );
        $this->load->view('template',$data);
    }    
   
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */