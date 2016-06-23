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

    public function getUsers()
    {
        $row = $this->fetchAll();
        if (!$row) {
            //throw new Exception("Could not find rows");
            return $row; //ovvero vuoto
        }
        return $row->toArray();
    } 


    public function setUser($id, $username, $password,$role)
    {
        $salt = sha1(rand(1,10));
        $data = array(
            'username' => $username,
            'password' => sha1($password.$salt),
            'role' => $role,
            'salt' => $salt
        );
        $this->update($data, 'id = '. (int)$id);
    }

    public function addUser($username,$password,$role) {
        $salt = sha1(rand(1,10));
        $data = array(
            'username' => $username,
            'password' => sha1($password.$salt),
            'role' => $role,
            'salt' => $salt,
            'date_created' => date("Y-m-d H:i:s")
        );
        $this->insert($data);
    }


       public function delUser($id)
    {
        $this->delete('id =' . (int)$id);
    }

}

