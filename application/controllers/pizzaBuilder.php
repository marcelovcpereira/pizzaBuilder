<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PizzaBuilder extends CI_Controller
{
    /**
     * Starts building the pizza
     */
    public function index($id="")
    {
		//Loading PizzaBuilderModel
		$this->load->model('pizzaBuilder_model');
		
		//Get the pizza builder object (contains all available crusts, sizes, etc)
        $pizzaBuilder = $this->pizzaBuilder_model->getPizzaBuilder();
		
		//Creating an empty pizza
		$pizza = new Pizza();
		
		//If theres a specified pizza id
		//let's seek the pizza and let user
		//edit it.
        if ($id !== "")
        {   
			$id = intval($id);
			//is valid number?
			if($id > 0)
			{
				$this->load->model('pizza_model');
				$pizza = $this->pizza_model->fetch($id);
			}
        }
		
		//var_dump($pizzaBuilder);
		
		//Initializing parameters to view
		$params = array(
			'history_title' => 'Build Your Pizza!',
			'pizzaBuilder'	=>	$pizzaBuilder,
			'pizza'	=>	$pizza
		);
		
		//Load the view with parameters
		$this->templatewrapper->load('pizzaBuilder_view', $params);
    }
}


/* End of file PizzaBuilder.php */
/* Location: ./application/controllers/PizzaBuilder.php */