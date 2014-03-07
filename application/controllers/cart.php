<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'models/domain/Pizza.php';
require_once APPPATH . 'models/domain/PizzaCrust.php';
require_once APPPATH . 'models/domain/PizzaEdge.php';
require_once APPPATH . 'models/domain/PizzaLayout.php';
require_once APPPATH . 'models/domain/PizzaFlavor.php';
require_once APPPATH . 'models/domain/PizzaSize.php';
class Cart extends CI_Controller
{
    /**
     * Starts building the pizza
     */
    public function index($id=null)
    {

		/* If the user has a pizza in session,
		 * let's retrieve it.
		 */
		$pizza = $this->session->userdata('customPizza');
		if($pizza !== FALSE)
		{
			
			//Decode string into json object
			$pizza = unserialize($pizza);

		}else{
			$pizza = null;
		}

		$cart = $this->cart->contents();

		//Initializing parameters to view
		$params = array(     
            'history_title' => 'Your Order',  
			'pizza'	=>	$pizza,
			'cart' => $cart,
            'user' => $this->authwrapper->getUser()
	   );
        $this->configwrapper->append($params);
		
		//Load the view with parameters

		$this->templatewrapper->load('cart_view', $this->configwrapper->toArray());
	}

	/**
	 * Adds an item to the cart and redirects to cart view.
	 * The user can add an item via PizzaBuilder submit, adding from Menu
	 * passing the pizza id as parameter or via cart view, updating item qty.
	 */
	public function add($id=null,$rowid=null)
	{
    	
		$pizza = null;
        /* Number of instances to be inserted */
        $count = 1;

		/* If the user is adding a default pizza from menu or updating item qty */
		if($id !== null)
		{
            /* Updating item on cart */
            if($rowid != null)
            {
                $this->_updateCart($rowid,$count);                
            }
            /* Adding a default pizza from menu */
            else
            {
                /* Lets see if this default pizza is already on cart */
                $exists = $this->_getRowId($id);
                if($exists != null)
                {
                    /* If this pizza already exists, just update it's qty */
                    $this->_updateCart($exists,$count);
                }
                else
                {
        			/* Else, Find the pizza */
        			$this->load->model('pizza_model');
        			$pizza = $this->pizza_model->fetch($id);            
                }
            }
		}
		/* If the user added a custom pizza from builder, it came via post */
		else
		{
            /* 
        	 * get from post and decode
			 */
        	$pizza = $this->input->post('userPizza');
        	if($pizza !== FALSE)
        	{
                //Loading PizzaBuilderModel
                $this->load->model('pizzaBuilder_model');
            
                //Get the pizza builder object (contains all available crusts, sizes, etc)
                $pizzaBuilder = $this->pizzaBuilder_model->getPizzaBuilder();

    			//Decode string into json object
        		$pizza = json_decode($pizza);

			     //Transform json object into Pizza object
        		$pizza = $pizzaBuilder->getPizzaByJSON($pizza);	
        	}
        }

        /* It's a new item on the cart */
        if($pizza !== null)
        {   
    		$cartPizza = array(
    			'id'      => $pizza->getId(),
    			'qty'     => 1,
    			'price'   => 10,
    			'name'    => $pizza->getName(),
    			'options' => array('type' => 'pizza','object'=> $pizza)
			);
    		$this->cart->insert($cartPizza);
        }
        redirect('cart');
        
    }

    public function remove($rowid=null)
    {
    	if($rowid != null)
    	{
    		$this->_updateCart($rowid,-1);        	
        }
    	redirect('cart');
    }

    public function update($rowid=null,$qty=null)
    {

        if($rowid != null && $qty != null)
        {
            $this->_updateCart($rowid,$qty,false);
        }
        redirect('cart');
    }


    private function _updateCart($rowid,$qty,$add=true)
    {
        $contents = $this->cart->contents();
        $quantity = $contents[$rowid]['qty'];

        if($add){
            $qty = $qty + $quantity;
        }

        $cartPizza = array(
            'rowid'      => $rowid,
            'qty'     => $qty
        );
        $this->cart->update($cartPizza);
    }

    private function _getRowId($id)
    {
        $rowid = null;
        foreach($this->cart->contents() as $item)
        {
            if($item['id'] == $id)
            {
                $rowid = $item['rowid'];
            }
        }
        return $rowid;
    }
}


/* End of file PizzaBuilder.php */
/* Location: ./application/controllers/PizzaBuilder.php */