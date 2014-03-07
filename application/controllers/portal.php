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

		//Parameters to the view       
        $cart = $this->cart->contents();

        $params = array(       
            'cart' => $cart,
            'user' => $this->authwrapper->getUser()
        );
        $this->configwrapper->append($params);
        //Load the home_view page with the user
        $this->templatewrapper->load('home_view', $this->configwrapper->toArray());
    }    

    /**
     * Renders the about page
     */
    public function about()
    {
        //Parameters to the view       
        $cart = $this->cart->contents();

        $data = array(
            'history_title' => 'About Pizza Builder',
            'cart'=>$cart,
            'user' => $this->authwrapper->getUser());
        $this->configwrapper->append($data);

        $this->templatewrapper->load('about_view', $this->configwrapper->toArray());
    }
   
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */