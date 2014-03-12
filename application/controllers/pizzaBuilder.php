<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PizzaBuilder extends CI_Controller {

    /**
     * Starts building the pizza
     */
    public function index($id = null) {
        //Loading PizzaBuilderModel
        $this->load->model('pizzaBuilder_model');

        //Get the pizza builder object (contains all available crusts, sizes, etc)
        $pizzaBuilder = $this->pizzaBuilder_model->getPizzaBuilder();



        /* If the user has just submitted a pizza,
         * let's save it in session
         */
        $pizza = $this->input->post('userPizza');
        if ($pizza !== FALSE) {

            //Decode string into json object
            $pizza = json_decode($pizza);

            //Transform json object into Pizza object
            $pizza = $pizzaBuilder->getPizzaByJSON($pizza);

            //Saving pizza in session
            $this->session->set_userdata('customPizza', serialize($pizza));
        }

        //Default is an empty pizza
        $pizza = null;

        //If theres a specified pizza id
        //let's seek the pizza and let user
        //edit it.
        if ($id !== null) {
            $id = intval($id);
            //is valid number?
            if ($id > 0) {
                $this->load->model('pizza_model');
                $pizza = $this->pizza_model->fetch($id);
            }
        }

        /* Doing manual CSRF protection because I'm not using CodeIgniter 
         * Form Helper (using twig templating), so I'll use the token name and hash in the view
         * to embed this data so codeigniter csrf protection does not
         * block the submition of the form
         */
        $CI = &get_instance();
        $tokenName = $CI->security->get_csrf_token_name();
        $tokenHash = $CI->security->get_csrf_hash();



        //Initializing parameters to view
        $params = array(
            'history_title' => 'Build Your Pizza!',
            'pizzaBuilder' => $pizzaBuilder,
            'pizza' => $pizza,
            'tokenName' => $tokenName,
            'tokenHash' => $tokenHash
        );

        $this->configwrapper->append($params);

        //Load the view with parameters
        $this->templatewrapper->load('pizzaBuilder_view', $this->configwrapper->toArray());
    }

}

/* End of file PizzaBuilder.php */
/* Location: ./application/controllers/PizzaBuilder.php */