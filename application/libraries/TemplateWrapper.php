<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Simple template Wrapper class.
 * This class is responsible for calling the template engine underneath it.
 * This way the controllers only knows this class, hence the templating system
 * can be easily changed.
 * that's a great place to implement factory pattern
 */
class TemplateWrapper 
{
    /*Using built-in template parser from CodeIgniter*/
    public static function load($page, $params)
    {
        $data = array(
          'home' => 'Home'  ,
            'profile' => 'Profile',
            'about' => 'About',
            'menu' => 'Menu',
            'product_name' => 'Pizza Builder',
            'account' => 'Account',
            'sign_up' => 'Sign Up',
            'login' => 'Login',
            'logout' => 'Logout',
            'header_title' => 'Pizza Builder'
        );
        
		$CI =& get_instance();
        $CI->parser->parse('_header',$data);
        $CI->load->view($page,$params);
        $CI->load->view('_footer');
    }
	
	/*Stub of using Twig Template Engine */
	public static function twigLoad($page,$params)
	{
		$twigLoader = new Twig_Loader_Filesystem(APPPATH.'views');
		$twigEnv = new Twig_Environment($twigLoader, array());
		echo $twigEnv->render($page,$params);
	}
}

/* End of file TemplateWrapper.php */
/* Location: ./application/controllers/TemplateWrapper.php */