<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The configuration array that contains ALL the validation rules
 * of the project
 */
$config = array(
    
    /**
     * Validation rules for the login form - Portal/login
     */
    'portal/login' => array(
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|xss_clean'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|trim|valid_email|xss_clean|strtolower'
            )
    ),
    
    /**
     * Validation rules for the seach property form - Portal/searchProperty
     */
    'portal/searchProperty' => array(
            
    ),
    /**
    * Alternate validation rule for the register form 
    * OBS: The register form is made of two parts:
    * 1) User basic data (name, last_name, email and pass)
    * 2) User address data (optional)
    * This rule validates ONLY BASIC DATA and IGNORES ADDRESS
    * See register_no_addr rule 
    */
    'noAddress' => array(
        array(
            'field' => 'name',
            'label' => 'First Name',
            'rules' => 'required|trim|xss_clean'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'required|trim|xss_clean'
        ),

        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|trim|xss_clean|valid_email|strtolower|is_unique[user.username]'
        ),

        array(
            'field' => 'email_confirm',
            'label' => 'Email confirmation',
            'rules' => 'required|trim|xss_clean|valid_email|strtolower|matches[email]'
        ),

        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|xss_clean'
        ),

        array(
            'field' => 'password_confirm',
            'label' => 'Password confirmation',
            'rules' => 'required|trim|xss_clean|matches[password]'
        )            
    ),
    
    /**
     * Default validation rules for the register form 
     * OBS: The register form is made of two parts:
     * 1) User basic data (name, last_name, email and pass)
     * 2) User address data (optional)
     * This rule validates both parts
     * See register_no_addr rule 
     */
    'portal/register' => array(
            array(
                'field' => 'name',
                'label' => 'First Name',
                'rules' => 'required|trim|xss_clean'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required|trim|xss_clean'
            ),
            
            array(
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'required|trim|xss_clean|valid_email|strtolower|is_unique[user.username]'
            ),
        
            array(
                'field' => 'email_confirm',
                'label' => 'Email confirmation',
                'rules' => 'required|trim|xss_clean|valid_email|strtolower|matches[email]'
            ),
        
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'password_confirm',
                'label' => 'Password confirmation',
                'rules' => 'required|trim|xss_clean|matches[password]'
            ),
            array(
                'field' => 'addr_name',
                'label' => 'Address',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_type',
                'label' => 'Address Type',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_number',
                'label' => 'Address Number',
                'rules' => 'required|trim|xss_clean|integer'
            ),
        
            array(
                'field' => 'addr_addition',
                'label' => 'Address additional informations',
                'rules' => 'trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_city',
                'label' => 'City',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_state',
                'label' => 'State',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_country',
                'label' => 'Country',
                'rules' => 'required|trim|xss_clean'
            ),
        
            array(
                'field' => 'addr_postal',
                'label' => 'Postal Code',
                'rules' => 'required|trim|xss_clean'
            )
        
    )
               
);
/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */