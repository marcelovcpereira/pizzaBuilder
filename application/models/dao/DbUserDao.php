<?php
require_once 'UserDao.php';
require_once APPPATH . 'models/domain/Address.php';
/**
 * Class that persists a User object in a Database.
 * It extends UserDao, so it will implement UserDao's abstract methods:
 * save,fetch and delete. 
 */
class DbUserDao extends UserDao
{
    private $table = 'user';
    private $addressTable = 'address';
    
    public function __construct($conn) {
        parent::__construct($conn);
    }
    
    
    public function delete() 
    {
        //stub
        return null;
    }

    /**
     * Searches the database for a User via 2 different criterias.
	 * By $id (with id = $id) or By $username and $password (authentication)
     * It constructs an instance of User and if it has an Address,
     * also creates the address and sets to the user.
     * This search is made with an LEFT OUTER JOIN, so if there is no
     * user address, the user will still return and the address will be
     * empty.
     * @param type $id int
     * @return type User
     */
    public function fetch($id,$pass = null) 
    {   
        //this function will return a null User if there's something wrong
        $user = null;
		//If there's no valid $id passed as argument, return empty
        if ($id !== null)
        {
			//Initializing an basic query
			$query = "SELECT "
					. "u.id,u.username,u.password,u.salt,u.name,u.last_name"
					. ",a.id AS address_id, a.name AS address_name, a.type, a.number, a.additional, a.city, "
					. "a.state, a.country, a.postal_code "
					. " FROM {$this->table} u"
					. " LEFT JOIN {$this->addressTable} a"
					. " ON u.address_id = a.id"
					. " WHERE ";
			
			
			/**
			 * If the password is given, then it's an user Authentication.
			 * So the first parameter is the username (instead of id) and 
			 * the second is the password. Let's create this query.
			 */
			if($pass !== null)
			{
				//Add checking username and password to the query
				$query .= "u.username = ?"
						." AND u.password = SHA2(CONCAT(u.salt,'" . $pass ."'),'". UserDao::SHA_ALGORITHM ."')";
			}
			/*
			 * This query selects the user by the id. It also search his address
			 * and returns an empty address if the user hasn't one.
			 */
			else
			{
				//Add id checking to the query
				$query .= "u.id = ?";
				
			}
			
			//Executes the query with the id as binder to the 
			//prepared Statement
			$result = $this->getConnection()->query($query,array($id));
			
			//If the search has results, lets create the User!
			if ($result->num_rows() > 0)
			{
				//Getting the returned table row
				$row = $result->row();
				
				//Creating the User instance
				$user = new User();
				$user->setId($row->id);
				$user->setUsername($row->username);
				$user->setName($row->name);
				$user->setLastName($row->last_name);
				$user->setPassword($row->password);
				$user->setSalt($row->salt);
				
				//If there is no Address to this user,
				//set a null Address
				$address = null;
				
				//Is there an Address associated to this user?
				//(id can't be null or empty
				if($row->address_id !== null && $row->address_id !== "")
				{					
					//...then create it's address
					$address = new Address();
					$address->setId($row->address_id);
					$address->setName($row->address_name);
					$address->setType($row->type);
					$address->setNumber($row->number);
					$address->setAdditionalInfo($row->additional);
					$address->setCity($row->city);
					$address->setState($row->state);
					$address->setCountry($row->country);
					$address->setPostalCode($row->postal_code);
				}                
				
				//Setting the address to the user
				$user->setAddress($address);                
			}
        }
        return $user;
    }

    public function save($object) 
    {
        //stub
        return null;
    }

}
/* End of file DbUserDao.php */
/* Location: ./application/controllers/DbUserDao.php */