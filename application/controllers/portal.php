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
		$this->load->view('template',array('page'=>'home_view'));
    }    
   
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */