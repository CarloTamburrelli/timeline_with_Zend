<?php

class Prova_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{    
	// default user role if not logged or (or invalid role found)
	private $_defaultRole = 'visitor';
	
	// the action to dispatch if a user doesn't have sufficient privileges
	private $_authController_default = array('module' => 'default', 'controller' => 'index', 'action' => 'index');
	
	public function __construct()
	{
		
	    $this->auth = Zend_Auth::getInstance();
	    $this->acl = new Zend_Acl();
	
	    // add the different user roles
	    $this->acl->addRole(new Zend_Acl_Role($this->_defaultRole));
	    $this->acl->addRole(new Zend_Acl_Role('default'),$this->_defaultRole);
   	    $this->acl->addRole(new Zend_Acl_Role('admin'),$this->_defaultRole);
	
	    // add the resources we want to have control over
	    $this->acl->add(new Zend_Acl_Resource('default'));
	    
	    $this->acl->add(new Zend_Acl_Resource('admin'));

	    // allow access to everything for all users by default
	    // except for the account management and administration areas
	    //$acl->deny();
	   	$this->acl->allow();
	    
	    // vieto l'accesso all'amministrazione a tutti
	    $this->acl->deny('default','admin');
	    $this->acl->deny($this->_defaultRole, 'admin');

	    $this->acl->deny($this->_defaultRole,'default',array('index:add'));
	    $this->acl->deny($this->_defaultRole,'default',array('index:logout'));

	    $this->acl->allow('default','default');
	    $this->acl->allow('admin','default');
	    $this->acl->allow('admin','admin');
	    $this->acl->allow('visitor','default',array('index:index'));
	    $this->acl->allow('visitor','default',array('index:showuser'));
	}
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {	
    	
        // check if a user is logged in and has a valid role,
        // otherwise, assign them the default role (guest)
        if ($this->auth->hasIdentity()){
            $role = $this->auth->getIdentity()->role;}
        else{
        	$role = $this->_defaultRole;
        }

        if (!$this->acl->hasRole($role)){
        	$role = $this->_defaultRole;}

        // the ACL resource is the requested controller name
        //$resource = $request->module;
        $resource = $request->module;

        // the ACL privilege is the requested action name
        //$privilege = $resource.':'.$request->controller.':'.$request->action;
        $privilege = $request->controller.':'.$request->action;
        
        // if we haven't explicitly added the resource, check
        // the default global permissions
        if (!$this->acl->has($resource)){
            $resource = null;
        }

        // access denied - reroute the request to the default action handler
        if (!$this->acl->isAllowed($role, $resource, $privilege)){
        	$parametri = $this->_authController_default;
        	$request->setModuleName($parametri['module']);
        	$request->setControllerName($parametri['controller']);
            $request->setActionName($parametri['action']);
        }
        
    }
}