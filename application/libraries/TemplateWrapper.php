<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Simple template Wrapper class.
 * This class is responsible for calling the template engine underneath it.
 * This way the controllers only knows this class and the templating system
 * can be easily changed.
 */
class TemplateWrapper 
{
    
    public static function load($page, $params)
    {
	$CI =& get_instance();
        $CI->load->view('_header');
        $CI->load->view($page,$params);
        $CI->load->view('_footer');
    }
}

/* End of file TemplateWrapper.php */
/* Location: ./application/controllers/TemplateWrapper.php */