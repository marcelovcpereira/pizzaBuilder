<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'models/domain/Pizza.php';
require_once APPPATH . 'models/domain/PizzaCrust.php';
require_once APPPATH . 'models/domain/PizzaEdge.php';
require_once APPPATH . 'models/domain/PizzaLayout.php';
require_once APPPATH . 'models/domain/PizzaFlavor.php';
require_once APPPATH . 'models/domain/PizzaSize.php';

/**
 * Controller class that handles user cart (add, remove and update products on cart).
 */
class Cart extends CI_Controller {

    /**
     * Default action. Starts building the pizza
     */
    public function index($id = null) {

        /* If the user has a pizza in session,
         * let's retrieve it.
         */
        $pizza = $this->session->userdata('customPizza');
        if ($pizza !== FALSE) {

            //Decode string into json object
            $pizza = unserialize($pizza);
        } else {
            $pizza = null;
        }


        //Initializing parameters to view
        $params = array(
            'history_title' => 'Your Order',
            'pizza' => $pizza
        );
        $this->configwrapper->append($params);

        //Load the view with parameters
        $this->templatewrapper->load('cart_view', $this->configwrapper->toArray());
    }

    /**
     * Adds an item to the cart and redirects to cart view.
     * The user can add an item via:
     * 1 - PizzaBuilder submit
     * 2 - Adding from Menu
     * 3 - Passing the pizza id as parameter to Cart add action
     * 4 - Click the plus sign in cart view
     */
    public function add($id = null, $rowid = null) {

        $pizza = null;
        /* Number of instances to be inserted */
        $count = 1;

        /* If the user is adding a default pizza from menu or updating item qty */
        if ($id !== null) {
            /* Updating item on cart */
            if ($rowid != null) {
                $this->_updateCart($rowid, $count);
            }
            /* Adding a default pizza from menu */ 
            else {
                /* Lets see if this default pizza is already on cart */
                $exists = $this->_getRowId($id);
                if ($exists != null) {
                    /* If this pizza already exists, just update it's qty */
                    $this->_updateCart($exists, $count);
                } else {
                    /* Else, Find the pizza */
                    $this->load->model('pizza_model');
                    $pizza = $this->pizza_model->fetch($id);
                }
            }
        }
        /* If the user added a custom pizza from builder, it came via post */ 
        else {
            /*
             * get from post and decode
             */
            $pizza = $this->input->post('userPizza');
            if ($pizza !== FALSE) {
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
        if ($pizza !== null) {
            $cartPizza = array(
                'id' => $pizza->getId(),
                'qty' => 1,
                'price' => 10,
                'name' => $pizza->getName(),
                'options' => array('type' => 'pizza', 'object' => $pizza)
            );
            
            /* Check if the user asked to add this pizza as favorite */            
            $fav = $this->input->post('favoriteCheck');
            if($fav !== FALSE && $fav == true)
            {
                $user = $this->authwrapper->getUser();

                $this->load->model('pizza_model');
                $this->load->model('user_model');

                /* Saving new pizza in database */
                $this->pizza_model->save($pizza);

                /* Saving pizza as favorite to user in database */
                $this->user_model->addFavoritePizza($user->getId(),$pizza->getId());

                /* Updating user object with the new favorite pizza */
                $user->addFavorite($pizza->getId());

                /* Updating session user data */
                $this->session->set_userdata('user', serialize($user));
            }
            
            $this->cart->insert($cartPizza);
        }
        redirect('cart');
    }

    /* Remove an item from the cart by rowid (codeigniter generated id)*/
    public function remove($rowid = null) {
        if ($rowid != null) {
            $this->_updateCart($rowid, -1);
        }
        redirect('cart');
    }

    /* Updates item quantity on cart */
    public function update($rowid = null, $qty = null) {

        if ($rowid != null && $qty != null) {
            $this->_updateCart($rowid, $qty, false);
        }
        redirect('cart');
    }

    /* Delete all item from cart */
    public function clear()
    {
        $this->cart->destroy();
        redirect('cart');
    }

    private function _updateCart($rowid, $qty, $add = true) {
        $contents = $this->cart->contents();
        $quantity = $contents[$rowid]['qty'];

        if ($add) {
            $qty = $qty + $quantity;
        }

        $cartPizza = array(
            'rowid' => $rowid,
            'qty' => $qty
        );
        $this->cart->update($cartPizza);
    }

    /* Returns the rowid based on item's $id.
     * Returns null if there's no item with given $id
     */
    private function _getRowId($id) {
        $rowid = null;
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == $id) {
                $rowid = $item['rowid'];
            }
        }
        return $rowid;
    }

}

/* End of file cart.php */
/* Location: ./application/controllers/cart.php */