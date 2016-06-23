<?php

class Zend_View_Helper_IsAdmin extends Zend_View_Helper_Abstract
{
    public function IsAdmin()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->getIdentity()->role === "admin") {
            return 1;
        }else {
            return 0;
        }
    }
}







