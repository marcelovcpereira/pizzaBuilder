<?php
require_once APPPATH . '/models/dao/DbPizzaDao.php';
require_once APPPATH . '/models/dao/DbPizzaCrustDao.php';
require_once APPPATH . '/models/dao/DbPizzaSizeDao.php';
require_once APPPATH . '/models/dao/DbPizzaEdgeDao.php';
require_once APPPATH . '/models/dao/DbPizzaLayoutDao.php';
require_once APPPATH . '/models/dao/DbIngredientDao.php';
require_once APPPATH . '/models/dao/DbPizzaFlavorDao.php';
require_once APPPATH . '/models/domain/PizzaBuilderDomain.php';
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
    
	/**
	 * Creates a PizzaBuilder object.
	 * Uses DAOs to fetch data and populate new instance or retrieve
	 * cached data.
	 */
    public function getPizzaBuilder()
	{
		/**
		 * Loading DAOs
		 */		
		$pizzaCrustDao = new DbPizzaCrustDao($this->db);	
		$pizzaSizeDao = new DbPizzaSizeDao($this->db);
		$pizzaEdgeDao = new DbPizzaEdgeDao($this->db);
		$pizzaLayoutDao = new DbPizzaLayoutDao($this->db);
		$pizzaFlavorDao = new DbPizzaFlavorDao($this->db);
		$ingredientDao = new DbIngredientDao($this->db);
		
		/* IMPLEMENT CACHE VERIFICATION HERE */
		
		/*
		 * Creating the PizzaBuilder object
		 */
		$pizzaBuilder = new PizzaBuilderDomain();
		$pizzaBuilder->setCrusts( $pizzaCrustDao->fetchAll() );
		$pizzaBuilder->setSizes( $pizzaSizeDao->fetchAll() );
		$pizzaBuilder->setEdges( $pizzaEdgeDao->fetchAll() );
		$pizzaBuilder->setLayouts( $pizzaLayoutDao->fetchAll() );
		$pizzaBuilder->setFlavors( $pizzaFlavorDao->fetchAll() );
		$pizzaBuilder->setIngredients( $ingredientDao->fetchAll() );
		
		return $pizzaBuilder;
	}

}
/* End of file pizzaBuilder_model.php */
/* Location: ./application/models/pizzaBuilder_model.php */