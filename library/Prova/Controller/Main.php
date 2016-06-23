<?php
/**
 * Utility Controller  - All the controllers not in admin module should extend it.
 *
 * @uses       Zend_Controller_Action
 * @category   App
 * @package    App_Controller
 */
class Prova_Controller_Main extends Zend_Controller_Action
{
    protected $esempio;
	
    public function preDispatch()
    {	
    	$form = new Default_Form_Upload();
        $form->setAction("/upload");
        $this->view->form_avatar = $form;
      
    }
    
    public function postDispatch()
    {
    	
    }
    
}