<?php

class IndexController extends Prova_Controller_Main
{


    public function indexAction()
    {   
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('/index/my_pagination.phtml');

        $comments = new Default_Model_Comment();
        $paginator = Zend_Paginator::factory($comments->getAllComments());
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setItemCountPerPage(6);

        // Assign the Paginator object to the view
        $this->view->comments = $paginator;        

        //$this->view->comments = $comments->getAllComments();

        $auth = Zend_Auth::getInstance();
        $form = new Default_Form_Login();
            if(!$auth->hasIdentity()){
                $this->view->form = $form;
                if($this->getRequest()->isPost()){
                        if($form->isValid($_POST)){
                            $email = $form->getValue('username');
                            $password = $form->getValue('password');
                            $msg = $this->authenticate($email, $password);
                            $this->view->msg = $msg;
                        }
                }
            }else {
                   $form_comment = new Default_Form_Comment();
                   $this->view->form_comment = $form_comment;
            }
    }

    public function uploadAction() {
        $form = new Default_Form_Upload();  
        $request = $this->getRequest();
        if ($request->isPost()) {
            $auth = Zend_Auth::getInstance();
            $originalFilename = pathinfo($form->file->getFileName());
            //$newFilename = 'file-' . $auth->getIdentity()->id . '.' . $originalFilename['extension'];
            $newFilename = 'file-' . $auth->getIdentity()->id . '.' ."jpg";
            $form->file->addFilter('Rename', $newFilename);
            try {
                $form->file->receive();
                //upload complete!
            } catch (Exception $e) {
                //error: file couldn't be received, or saved (one of the two)
            }
        }
            $this->_redirect("/");
    }




        private function authenticate($username, $password){

        $msg = '';
        $db = Zend_Registry::get('db');
        $auth = Zend_Auth::getInstance();
        $method = 'SHA1(CONCAT(?,salt))';

        $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password', $method);
        //$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'email', 'password','MD5(?) AND active=1');
        $authAdapter->setIdentity($username)
                    ->setCredential($password);
        
        $authResult = $auth->authenticate($authAdapter);
        $auth->getStorage()->write($authAdapter->getResultRowObject(null,'password'));
        
        if ($authResult->isValid()){
            $msg="bene";
            //$modelUser = new Mado_Model_Users();
            //$modelUser->updateLastAccess($auth->getIdentity()->id);
            //$modelUser->assignSessionToId($auth->getIdentity()->id);
            $this->_redirect('/');
        }else{
            $msg="Password errata";
            $auth->clearIdentity();
        }

        return $msg;    
    }

    public function addAction() {
        //add a comment
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $comment = $this->getRequest()->body;
            $userInfo = Zend_Auth::getInstance()->getStorage()->read();
            $comments = new Default_Model_Comment();
            $comments->addComment($userInfo->id, $comment );
        }
        $this->_redirect('/');

    }



    public function logoutAction()
    {   
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/');
    }

    public function showuserAction()
    {   
        $id = $this->_getParam('id');
        if($id==0){
            $this->_redirect('/');
        }else {
            $user = new Default_Model_User();
            $profile = $user->getUser($id);
            if($profile){ //l'utente esiste!
                $this->view->name = $profile['username'];
                $this->view->ruolo = $profile['role'];
                $this->view->giorno = $profile['date_created'];
            }else {
                $this->view->name = "UTENTE INESISTENTE";
            }

        }
        $auth = Zend_Auth::getInstance();
        if(!$auth->hasIdentity()) {
            $form = new Default_Form_Login();
            $this->view->form = $form;
        }
    }

   


}







