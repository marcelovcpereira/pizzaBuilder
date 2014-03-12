<?php
require_once APPPATH . '/models/dao/DbPizzaDao.php';
/**
 * Model representation of the Pizza Entity.
 * This class manipulates persistance via a PizzaDao
 */
class Pizza_model extends CI_Model 
{
		private $pizzaDAO;
		
		/**
		 * Constructs the model instance, loads the database conector 
		 * of CodeIgniter and gets an instance of the PizzaDAO passing
		 * the database connector.
		 */
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->pizzaDAO = new DbPizzaDao($this->db);
                        
		}		
		
		/**
		 * Asks the PizzaDAO to list all pizzas in the database.
		 */
		public function getMenu()
		{
            return $this->pizzaDAO->fetchAll();
		}

		/**
		 * Asks the PizzaDAO to find a pizza by id.
		 */
		public function fetch($id)
		{
			return $this->pizzaDAO->fetch($id);
		}
}
/* End of file pizza_model.php */
/* Location: ./application/models/pizza_model.php */