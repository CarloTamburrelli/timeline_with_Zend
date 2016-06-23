<?php

class Admin_Form_Modifyuser extends Zend_Form
{
public function init()
{
	$this->setName("modify");
	$this->setMethod('post');

	$id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        $this->addElements(array($id));

	$this->addElement('text', 'username', 
	array(
		'filters' => array('StringTrim', 'StringToLower'),
		'validators' => array(array('StringLength', false, array(0, 50)),
		),
	'required' => true,
	'label' => 'Username:',
	));

	$this->addElement('password', 'password', array(
	'filters' => array('StringTrim'),
	'validators' => array(
	array('StringLength', false, array(0, 50)),
	),
	'required' => true,
	'label' => 'Password:',
	));

	$this->addElement('text', 'role', 
	array(
		'filters' => array('StringTrim', 'StringToLower'),
		'validators' => array(array('StringLength', false, array(0, 50)),
		),
	'required' => true,
	'label' => 'Ruolo:',
	));

	$this->addElement('submit', 'login', array(
	'required' => false,
	'ignore' => true,
	'label' => 'Login',
	));
}
}

