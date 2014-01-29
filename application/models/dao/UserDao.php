<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain User.
 * It will be used by the models to access the persistant users objects
 * It should have implementations like DbUserDao, FileUserDao, CloudUserDao,
 * or any additional type of persistance. The model layer is completely
 * unaware of the persistance type.
 * It can have specific features that only a UserDao have (not all Dao).
 */
abstract class UserDao implements Dao
{
    
    //Mysql SHA2 Parameter
    //indicates the version of SHA algorithm for the password hashing
    //224, 256, 384, 512, or 0 (which is equivalent to 256)
    const SHA_ALGORITHM = '256';
    protected $connection;

    public function __construct($conn)
    {
        $this->connection = $conn;
    }
    
    //To be overwritten by the Concrete SubClasses
    abstract public function fetch($id);
    abstract public function delete();
    abstract public function save($object);
    
}
/* End of file UserDao.php */
/* Location: ./application/controllers/UserDao.php */