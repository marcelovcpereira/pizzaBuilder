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
		//that's the user who is here
        $user = null;
		//Parameters to the view
        $data = array('user' => $user); 
        //Load the home_view page with the user
        $this->templatewrapper->load('home_view', $data);
    }    

    public function about()
    {
        $data = array('history_title' => 'About Pizza Builder');
         $this->templatewrapper->load('about_view', $data);
    }
   
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */