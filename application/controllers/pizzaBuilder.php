<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PizzaBuilder extends CI_Controller
{
    /**
     * Starts building the pizza
     */
    public function index()
    {
		$this->_load_index();
    }
    
    /**
     * Loads the view page
     */
    private function _load_index()
    {
       $this->load->view('template', array('page' => 'menu_view'));
    }
    
    
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */