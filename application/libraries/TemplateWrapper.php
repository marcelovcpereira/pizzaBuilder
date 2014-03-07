<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Simple template Wrapper class.
 * This class is responsible for calling the template engine underneath it.
 * This way the controllers only knows TemplateWrapper class, hence the templating system
 * can be easily changed.
 * that's a great place to implement factory pattern: TemplateFactory
 */
class TemplateWrapper 
{

    //Stub. This will be changed to OO design. For now, it's just a String
    private $templateEngine = "twig";
    //Default value for header template
    private $header = '_header';
    //Default value for footer template
    private $footer = '_footer';
    //Template file default prefix
    private $prefix = "twig_";
    //Template file default sufix
    private $sufix = ".html";

    /**
     * Parameters to Header template. We could
     * load it from a file, but for now, let's keep it up here
     */
    static $data = array(
        'home' => 'Home',
        'profile' => 'Profile',
        'about' => 'About',
        'menu' => 'Menu',
		'builder' => 'Builder',
        'cart_link' => 'Your Cart',
        'product_name' => 'Pizza Builder',
        'account' => 'Account',
        'sign_up' => 'Sign Up',
        'login' => 'Login',
        'logout' => 'Logout',
        'header_title' => 'Pizza Builder'
    );

    /**
     * Sets the TemplateWrapper engine
     */
    public function set($engine = "twig") {
        switch ($engine) {
            case "ci":
                $this->templateEngine = "ci";
                $this->prefix = "ci_";
                $this->sufix = ".php";
                break;
            case "twig":
            default:
                $this->templateEngine = "twig";
                $this->prefix = "twig_";
                $this->sufix = ".html";
                break;
        }
    }

    /**
     * Loads the underneath engine render
     */
    public function load($page, $params) {
        //Configuring the template file name
        $page = $this->prefix . $page . $this->sufix;

        switch ($this->templateEngine) {
            //If "ci", load Code Igniter template
            case "ci":
                $this->ciLoad($page, $params);
                break;
            //If "twig" or not specified, load Twig template
            case "twig":
            default:
                $this->twigLoad($page, $params);
                break;
        }
    }

    /* Using built-in template parser from CodeIgniter */

    private function ciLoad($page, $params) {
        $dir = 'ci/';

        /* Refers to the global instance of Code Igniter */
        $CI = & get_instance();
        /* Parse the header template */
        $CI->parser->parse($dir . $this->prefix . $this->header . $this->sufix, TemplateWrapper::$data);
        /* Render the actual page */
        $CI->load->view($dir . $page, $params);
        /* Parse the footer template */
        $CI->load->view($dir . $this->prefix . $this->footer . $this->sufix);
    }

    /* Using Twig Template Engine */

    private function twigLoad($page, $params) {

        /* Loading Twig Filesystem Loader */
        $twigLoader = new Twig_Loader_Filesystem(APPPATH . 'views/twig');
        /* Loading Twig Environment */
        $twigEnv = new Twig_Environment($twigLoader, array('debug' => true));
		$twigEnv->addExtension(new Twig_Extension_Debug());

        /*var_dump($params);
        var_dump(TemplateWrapper::$data);
        /* Rendering the header tenplate */
        echo $twigEnv->render($this->prefix . $this->header . $this->sufix, $params);
        /* Rendering the actual page */
        echo $twigEnv->render($page, $params);
        /* Rendering the footer template */
        echo $twigEnv->render($this->prefix . $this->footer . $this->sufix);
    }

    public function ciTwigPageLoad($page, $params)
    {

         /* Loading Twig Filesystem Loader */
        $twigLoader = new Twig_Loader_Filesystem(APPPATH . 'views/twig');
        /* Loading Twig Environment */
        $twigEnv = new Twig_Environment($twigLoader, array('debug' => true));
        $twigEnv->addExtension(new Twig_Extension_Debug());


        /* Rendering the header tenplate */
        $output = $twigEnv->render($this->prefix . $this->header . $this->sufix, $params);

        $dir = 'ci/';

        /* Refers to the global instance of Code Igniter */
        $CI = & get_instance();
        /* Render the actual page */
        $output = $output . $CI->parser->parse($dir . "ci_" . $page , $params,true);

        /* Rendering the footer template */
        $output = $output . $twigEnv->render($this->prefix . $this->footer . $this->sufix);

        echo $output;
    }

}

/* End of file TemplateWrapper.php */
/* Location: ./application/libraries/TemplateWrapper.php */