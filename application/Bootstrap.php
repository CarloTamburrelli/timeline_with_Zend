<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    protected function _initAutoload()
	{	

		ini_set("soap.wsdl_cache_enabled", 0);

		//error_reporting(E_ALL ^ E_DEPRECATED ^ E_STRICT);

		//error_reporting('E_ALL & ~E_STRICT');
		//ini_set('display_errors', 'on');
		
	    return new Zend_Application_Module_Autoloader(
	    			array(
	                	'namespace' => 'Default',
	                	'basePath' => APPLICATION_PATH . '/modules/default'),
			        array(
			            'namespace' => 'Admin',
			            'basePath' => APPLICATION_PATH . '/modules/admin')
	    );
	}


	 protected function _initDbAdapter()
    {    
    	$this->bootstrap('db');
        $db = $this->getResource('db');
        try{
        	$db->getConnection();
        }catch(Zend_Exception $e){
        	echo "Errore di connessione al database. Contattare l'amministratore di sistema";
        	exit;}
        
        $db->query("SET NAMES 'utf8'");
        $db->query("SET CHARACTER SET 'utf8'");
        Zend_Registry::set('db',$db);
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        //$cache = Zend_Registry::get('cache');
        //Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
    }



	protected function _initRouters()
    {
        $controller = Zend_Controller_Front::getInstance();
	   	$router = $controller->getRouter();
	    
	    //default route
	  	$router->addRoute('home',new Zend_Controller_Router_Route('/:page', array('module' => 'default','controller' => 'index', 'action' => 'index', 'page' => 1)));
	  	$router->addRoute('exec_comment',new Zend_Controller_Router_Route('/add', array('module' => 'default','controller' => 'index', 'action' => 'add')));
	  	$router->addRoute('exec_logout',new Zend_Controller_Router_Route('/logout', array('module' => 'default','controller' => 'index', 'action' => 'logout')));
	  	$router->addRoute('exec_showuser',new Zend_Controller_Router_Route('/user/:id', array('module' => 'default','controller' => 'index', 'action' => 'showuser', 'id' => 0)));
	  	$router->addRoute('exec_upload',new Zend_Controller_Router_Route('/upload', array('module' => 'default','controller' => 'index', 'action' => 'upload')));
	  
	   	//admin route	
	   	$router->addRoute('exec_settings',new Zend_Controller_Router_Route('/admin', array('module' => 'admin','controller' => 'index', 'action' => 'index')));
	  	$router->addRoute('exec_admin_user',new Zend_Controller_Router_Route('/admin/user/:id', array('module' => 'admin','controller' => 'index', 'action' => 'admin-user', 'id' => 0)));
	  	$router->addRoute('exec_admin_deluser',new Zend_Controller_Router_Route('/admin/del_user/:id', array('module' => 'admin','controller' => 'index', 'action' => 'admin-deluser', 'id' => 0)));
		$router->addRoute('exec_add_user',new Zend_Controller_Router_Route('/admin/add', array('module' => 'admin','controller' => 'index', 'action' => 'add')));
	  	
	}



	

}

