<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller
{
    /**
     * Default page of the Menu
     */
    public function index()
    {
		//Loading PizzaModel
		$this->load->model('pizza_model');
		
		//Get a List of pizzas of the menu
		//$menu = $this->pizza_model->getMenu();
                $pizzas = $this->pizza_model->getMenu();
		
		//Parameters to the view. Each index will be
		//a variable at the view level.		
		$viewParams = array('page' => 'menu_view',
                                    'pizzas' => $pizzas);
							
		//I should create a Templator, because /\ this
		//call is a little bit confusing
		
		//Load the menu_view page withOUT the list of pizzas as menu
		$this->templatewrapper->load('menu_view', $viewParams);
                //$this->load->view('template', $viewParams);		
    }
    
        
    
}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */