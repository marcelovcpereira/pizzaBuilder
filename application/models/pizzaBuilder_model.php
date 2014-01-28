<?php
require_once APPPATH . '/models/domain/User.php';
require_once APPPATH . '/models/dao/DBUserDao.php';
/**
 * Model representation of the PizzaBuilder Entity. 
 * This class manipulates persistance via pizza parts Daos.
 * 
 */
class PizzaBuilder_model extends CI_Model 
{    
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        
    }
    
    //stub
    public function getPizzaBuilder()
    {
        //stub
    }
}
/* End of file pizzaBuilder_model.php */
/* Location: ./application/models/pizzaBuilder_model.php */