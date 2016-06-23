<?php

class Default_Form_Upload extends Zend_Form
{
	public function init()
	{
			$this->setAttrib('enctype', 'multipart/form-data');
	        $this->setMethod('post');

	        $file = new Zend_Form_Element_File('file');
	        $file->setRequired(true)
	        	->setDestination(APPLICATION_PATH ."/../public/tmp")
	            ->addValidator('NotEmpty')
	            ->addValidator('Count', false, 1);
	        $this->addElement($file);

	        $this->addElement('submit', 'submit', array(
	            'label'    => 'Upload',
	            'ignore'   => true
	        ));
	}
}

