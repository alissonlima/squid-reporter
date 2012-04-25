<?php

class Reporter_Form_Element_BrState extends Zend_Form_Element_Xhtml
{
	public $helper = 'formBrState';

	public function init ()
	{
		//$this->addValidator(new Reporter_Validate_BrState());
	}

	
	public function isValid ($value, $context = null)
	{
		// ignoring value -- it'll be empty
		
		$name = $this->getName();

		$this->_value = $value;
		
		return parent::isValid($value, $context);
	}

}

