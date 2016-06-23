<?php

class Default_Model_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';


    public function getUser($id)
    {
        $id = (int)$id;

        $row = $this->fetchRow('id = '.$id);
        if (!$row) {
            //throw new Exception("Could not find rows");
            return $row; //ovvero vuoto
        }
        return $row->toArray();
    } 




}

