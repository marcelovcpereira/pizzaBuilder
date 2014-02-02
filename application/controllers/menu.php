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
        $pizzas = $this->pizza_model->getMenu();
		
		//Parameters to the view
		$viewParams = array('pizzas' => $pizzas);							
		
		//Load the menu_view page with the list of pizzas as menu
		$this->templatewrapper->set('twig');
		$this->templatewrapper->load('menu_view', $viewParams);
    }
    
        
    
}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */