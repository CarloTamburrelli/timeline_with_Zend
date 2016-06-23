<?php

class Default_Model_Comment extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

    public function getAllComments()
    {
$select = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('u' => 'users'),array('u.*', 'c.*'))
                ->join(array('c' => 'comments'), 'c.id_user = u.id',null)->order('c.id DESC');



        $row = $this->fetchall($select);
        if (!$row) {
            //throw new Exception("Could not find rows");
            return $row; //ovvero vuoto
        }
        return $row->toArray();
    }

    public function addComment($id, $comment)
    {
        $date = new Zend_Date();
        $data = array(
            'id_user' => $id,
            'comment' => $comment,
            'date_created' => date("Y-m-d H:i:s")
        );
        $this->insert($data);
    }

    /*
    public function updateAlbum($id, $artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title' => $title,
        );
        $this->update($data, 'id = '. (int)$id);
    }

    public function deleteAlbum($id)
    {
        $this->delete('id =' . (int)$id);
    }
    */

}

