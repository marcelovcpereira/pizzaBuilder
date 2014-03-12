<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';

/**
 * Controller class that handles user authentication (login and registration).
 */
class Auth extends CI_Controller {

    /**
     * Default page of the Menu
     */
    public function index() {
        /* If the user is logged, send him to home */
        if ($this->authwrapper->isLogged()) {
            redirect();
        }
        /* Delimiting CodeIgniter validation errors */
        $this->_delimitErrors();

        /* If validation fails, show login again */
        if ($this->form_validation->run() === FALSE) {
            /* This time we'll get validation errors on screen */
            $this->_load_login();
        } else {
            /* If validation is successful... */
            $this->load->model('user_model');

            /* Get submitted username and password */
            $pass = $this->input->post('password');
            $username = $this->input->post('username');

            //Trying to login...
            $user = $this->user_model->fetch($username, $pass);

            //if the login failed
            if ($user === null) {
                $data = array('status' => 'login failed', 'error' => 'Invalid username or password');
                $this->_load_login($data);
            }
            //if the login matched
            else {
                //Save user in session
                $this->session->set_userdata('user', serialize($user));
                //Loads home view        
                redirect();
            }
        }
    }

    public function register($data = array()) {

        if ($this->authwrapper->isLogged()) {
            redirect();
        }

        //Loading models
        $this->load->model('user_model');
        $this->load->model('address_model');

        /* Delimiting CodeIgniter validation errors */
        $this->_delimitErrors();
        $this->_uniqueErrorMessage();

        //Getting the hidden post variable showAddress
        //that indicates if the user sent address data or not
        $showAddress = $this->input->post('showAddress'); //hidden input
        //the default validation rule will also validate the address info
        //If you change it to register_no_addr, it will ignore address info
        $validationRule = '';

        //If the user did not send address info
        if (isset($showAddress) && $showAddress === 'FALSE') {
            //Use the register_no_addr rule instead of default registration rule
            $validationRule = 'noAddress';
        }



        if ($this->form_validation->run($validationRule) === FALSE) {
            $this->_load_register();
        } else {

            //Gathering user data
            $name = $this->input->post('name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');


            $added_id = null;
            if ($showAddress !== 'FALSE') {
                //Gathering user address
                $address = $this->input->post('addr_name');
                $addr_type = $this->input->post('addr_type');
                $addr_additional = $this->input->post('addr_addition');
                $addr_number = $this->input->post('addr_number');
                $addr_city = $this->input->post('addr_city');
                $addr_state = $this->input->post('addr_state');
                $addr_country = $this->input->post('addr_country');
                $addr_postal = $this->input->post('addr_postal');

                //Trying to add the user address... 
                $added_id = $this->address_model->add_address($address, $addr_type, $addr_number, $addr_additional, $addr_city, $addr_state, $addr_country, $addr_postal);
            }


            //If there was an error when trying to add the address...
            if ($added_id === -1 OR $added_id === -2) {
                //there's something wrong
                $this->_load_register_view(array('error' => 'PAU:' . $added_id));
            }
            //If the address was successfully added, let's try to add the User
            else {
                //Try adding the user to database
                $this->user_model->add_user($name, $last_name, $email, $password, $added_id);

                //Loads 
                redirect();
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

    public function login() {
        return $this->index();
    }

    public function _load_register($data = array()) {

        //Parameters to the view
        $viewParams = array_merge($data, array(
            'history_title' => 'Register',
            'form_title' => 'Login',
            'username' => 'Username',
            'password' => 'Password',
            'sign_in' => 'Sign In',
            'form_title' => 'Sign Up to Pizza Builder',
            'name' => 'Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'confirm_email' => 'Confirm Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'address_panel' => 'Address Information',
            'address_type' => 'Address Type',
            'address' => 'Address',
            'number' => 'Number',
            'add_info' => 'Complement',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'zip' => 'Zip/Postal Code',
            'show_address_toggle' => '+ Address',
            'showAddress' => 'FALSE'
                ));

        $this->configwrapper->append($viewParams);

        //Load the menu_view page with the list of pizzas as menu
        $this->templatewrapper->ciTwigPageLoad('register_view', $this->configwrapper->toArray());
    }

    public function _load_login($data = array()) {

        //Parameters to the view
        $viewParams = array_merge($data, array(
            'history_title' => 'Login',
            'form_title' => 'Login',
            'username' => 'Username',
            'password' => 'Password',
            'sign_in' => 'Sign In'
                ));

        $this->configwrapper->append($viewParams);

        //Load the menu_view page with the list of pizzas as menu
        $this->templatewrapper->ciTwigPageLoad('login_view', $this->configwrapper->toArray());
    }

    private function _delimitErrors() {
        /* Getting delimiters of error messages in config wrapper */
        $delimiters = $this->configwrapper->get('error_delimiters');
        $errorOpen = $delimiters[0];
        $errorClose = $delimiters[1];
        /* Setting delimiters of error messages in CodeIgniter form_validation */
        $this->form_validation->set_error_delimiters($errorOpen, $errorClose);
    }

    public function _uniqueErrorMessage()
    {
        $this->form_validation->set_message('is_unique', 'This value is already registered');
    }

}

/* End of file menu.php */
/* Location: ./application/controllers/menu.php */