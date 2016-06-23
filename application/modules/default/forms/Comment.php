<?php

class Default_Form_Comment extends Zend_Form
{
public function init()
{
	$this->setName("login");
	$this->setMethod('post');

$body = new Zend_Form_Element_Textarea('body');
$body->setLabel('Body:')
    ->setRequired(true)
    ->setAttrib('class', 'form_control')
    ->setAttrib('COLS', '40')
    ->setAttrib('ROWS', '4');
$this->addElement($body);


	$this->addElement('submit', 'login', array(
	'required' => false,
	'ignore' => true,
	'label' => 'Login',
    'class' => 'btn btn-primary',
	));
}
}

