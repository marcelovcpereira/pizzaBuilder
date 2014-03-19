<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'models/domain/User.php';
require_once APPPATH . 'models/domain/Address.php';

/* Default controller of PizzaBuilder Application,
 * Show the home page view and about view 
 */
class Portal extends CI_Controller
{
    /**
     * Default action of the portal, redirects to Home
     */
    public function index()
    {
        //Load the home_view page with the user
        $this->templatewrapper->load('home_view', $this->configwrapper->toArray());
    }    

    /**
     * Renders the about page
     */
    public function about()
    {
        $data = array('history_title' => 'About Pizza Builder');
        $this->configwrapper->append($data);

        $this->templatewrapper->load('about_view', $this->configwrapper->toArray());
    }

    /* Action that sends user messages to pizzaBuilder */
    public function contact()
    {
        /* Getting delimiters of error messages in config wrapper */
        $delimiters = $this->configwrapper->get('error_delimiters');
        $errorOpen = $delimiters[0];
        $errorClose = $delimiters[1];
        /* Setting delimiters of error messages in CodeIgniter form_validation */
        $this->form_validation->set_error_delimiters($errorOpen, $errorClose);

        /* If there's something wrong with form data, reload contact view */
        if ($this->form_validation->run() === FALSE) 
        {
            $this->_loadContact();
        } 
        else 
        {
            /**
             * SIMPLE ANTI BOT VERIFICATION
             * Get the useless submitted field, if it's value is setted,
             * then it was a bot sending the form, let's ignore this request 
             */
            $useless = $this->input->post('secret');
            if($useless !== '')
            {
                redirect('contact');
            }


            /* Get submitted fields */
            $name = $this->input->post('name');
            $replyTo = $this->input->post('email');            
            $msg = $this->input->post('message');

            /* Initializing additional email fields */
            $to = "marcelovcpereira@gmail.com";
            $from = "noreply@pizzabuilder.com";

            /* Loading CodeIgniter Email class */
            $this->load->library('email');

            /* Setting email attributes */
            $this->email->from($from, $name);
            $this->email->to($to); 
            $this->email->reply_to($replyTo);
            $this->email->subject('[PizzaBuilder] Contact');
            $this->email->message($msg);  
            /* Sending email... */
            $sent = @$this->email->send();

            if($sent)
            {
                $this->_loadContact(array('status' => 'Email Sent'));
            }
            else
            {
                $this->_loadContact(array('error' => 'Failed to send email'));   
            }
        }
        
    }

    public function _loadContact($params=null)
    {
        $data = array('history_title' => 'Contact Us');

        if($params !== null)
        {
            $data = array_merge($data,$params);
        }

        $this->configwrapper->append($data);

        $this->templatewrapper->ciTwigPageLoad('contact_view', $this->configwrapper->toArray());   
    }
   
}


/* End of file portal.php */
/* Location: ./application/controllers/portal.php */