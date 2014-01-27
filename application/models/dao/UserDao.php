<?php
require_once 'Dao.php';
/**
 * Represents an abstract DAO for the domain User
 */
abstract class UserDao extends Dao
{
    
    //Mysql SHA2 Parameter
    //indicates the version of SHA algorithm
    //224, 256, 384, 512, or 0 (which is equivalent to 256)
    const SHA_ALGORITHM = '256';
    

    public function __construct($conn)
    {
        parent::__construct($conn);
    }
    
    
    }


