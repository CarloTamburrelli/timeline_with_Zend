<?php

class Zend_View_Helper_IsLog extends Zend_View_Helper_Abstract
{
    public function IsLog()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return 1;
        }else {
            return 0;
        }
    }
}







