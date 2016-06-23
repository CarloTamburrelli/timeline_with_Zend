<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

    switch ($errors->type) {
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

            // 404 error -- controller or action not found
            $this->getResponse()->setHttpResponseCode(404);
            $this->view->message = 'Page not found';
            break;

        // check for any other exception
        case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
            if ($errors->exception instanceof My_Exception_Blocked) {
                $this->getResponse()->setHttpResponseCode(403);
                $this->view->message = $errors->exception->getMessage();
                break;
            }
            // fall through if not of type My_Exception_Blocked

        default:
            // application error
            $this->getResponse()->setHttpResponseCode(500);
            $this->view->message = 'Application error';
            break;
    }
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

