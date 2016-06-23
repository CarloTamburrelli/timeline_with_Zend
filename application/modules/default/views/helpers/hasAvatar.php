<?php

class Zend_View_Helper_HasAvatar extends Zend_View_Helper_Abstract
{
    public function hasavatar($id)
    {
        $filename = 'tmp/file-'.$id.'.jpg';
		if (file_exists($filename)) {
				return 1;
		    }else {
		    	return 0;
		    }
		}
}







