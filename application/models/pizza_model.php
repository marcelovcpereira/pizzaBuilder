<?php
require_once APPPATH . '/models/dao/DbPizzaDao.php';
require_once APPPATH . '/models/dao/DbPizzaCrustDao.php';
require_once APPPATH . '/models/dao/DbPizzaSizeDao.php';
require_once APPPATH . '/models/dao/DbPizzaEdgeDao.php';
require_once APPPATH . '/models/dao/DbPizzaLayoutDao.php';
require_once APPPATH . '/models/dao/DbIngredientDao.php';
require_once APPPATH . '/models/dao/DbPizzaFlavorDao.php';


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
                        //$this->pizzaDAO = new DbPizzaCrustDao($this->db);
                        //$this->pizzaDAO = new DbPizzaSizeDao($this->db);
                        //$this->pizzaDAO = new DbPizzaEdgeDao($this->db);
                        //$this->pizzaDAO = new DbPizzaLayoutDao($this->db);
                        //$this->pizzaDAO = new DbIngredientDao($this->db);
                        //$this->pizzaDAO = new DbPizzaFlavorDao($this->db);
                        
		}		
		
		/**
		 * Asks the PizzaDAO to list all pizzas in the database.
		 * It knows that the menu requested by the controller is made only 
		 * of pizzas(business logic). If the store decides to add new foods
		 * it should be changed to look up for additional DAOs and build
		 * the menu of Foods.
		 */
		public function getMenu()
		{
            return $this->pizzaDAO->fetchAll();
		}

		public function fetch($id)
		{
			return $this->pizzaDAO->fetch($id);
		}
}
/* End of file pizza_model.php */
/* Location: ./application/models/pizza_model.php */