<?php

/* 
 * This interface indicates what a DAO should do.
 * Every DAO object should be able to execute the CRUD operations.
 * @author     marcelovcpereira
 * @since      v0.1 Dev
 * @package    models.domain
 * @access     public
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */
interface Dao
{    
    public function fetch($id);
    public function fetchAll();
    public function delete($object);
    public function save($object);
    
}
/* End of file Dao.php */
/* Location: ./application/controllers/Dao.php */