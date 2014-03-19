<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller that shows the store menu
 */
class Menu extends CI_Controller
{
    /**
     * Default action of the Menu
     */
    public function index()
    {
		//Loading PizzaModel
		$this->load->model('pizza_model');
		
		//Get a List of pizzas of the menu
        $pizzas = $this->pizza_model->getMenu();
		
		//Parameters to the view
		$viewParams = array(			
	        'pizzas' => $pizzas,
            'history_title'=>'Menu'
        );

        $this->configwrapper->append($viewParams);		
		
		//Load the menu_view page with the list of pizzas as menu
		$this->templatewrapper->load('menu_view', $this->configwrapper->toArray());
    }
    
        
    
}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */