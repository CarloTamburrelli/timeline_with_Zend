<?php

class Admin_IndexController extends Prova_Controller_Main
{


    public function indexAction()
    {
    	$form = new Admin_Form_Modifyuser();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
         		$id   = $form->getValue('id');
         		$user = $form->getValue('username');
                $pass = $form->getValue('password');
                $role = $form->getValue('role');
                $users = new Default_Model_User();
                $users->setUser($id, $user, $pass,$role);
            }else {
 				$this->view->message = $form->getMessages();
            }
        }
    	$users = new Default_Model_User();
        $this->view->users = $users->getUsers();
    }
    public function addAction()
    {
    	$form = new Admin_Form_Modifyuser();
    	$request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
            	$user = $form->getValue('username');
                $pass = $form->getValue('password');
                $role = $form->getValue('role');
    			$users = new Default_Model_User();
                $users->addUser($user, $pass,$role);
                $this->_redirect("admin");
    		}else {
    			$this->_forward('index','index');
    		}
    	} 
    	$form_add = new Admin_Form_Modifyuser();
    	$this->view->form_add = $form_add;
    }

     public function adminUserAction()
    {		

    	$id = $this->_getParam('id');
    	if($id==0){
    		$this->_redirect('/');
    	}else {
    		$user = new Default_Model_User();
    		$form_user = new Admin_Form_Modifyuser();
    		$this->view->form_user = $form_user;
    		$form_user->populate($user->getUser($id));
    	}
    }

     public function adminDeluserAction()
    {
    	$id = $this->_getParam('id');
        if($id!=0){
    	$users = new Default_Model_User();
        $this->view->users = $users->delUser($id);

    		$this->_redirect('/admin');
    	}else {
    		$this->_redirect('/');
    	}
    }


}







