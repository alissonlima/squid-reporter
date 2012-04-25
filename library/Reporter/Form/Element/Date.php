<?php

class Reporter_Form_Element_Date extends Zend_Form_Element_Xhtml
{
	public $helper = 'formDate';

	public function init ()
	{
		$this->addValidator(new Reporter_Validate_Date());
	}

	
	public function isValid ($value, $context = null)
	{
		// ignoring value -- it'll be empty
		
		$name = $this->getName();

		$value = $context[$name . '_year'] . '-' .
					$context[$name . '_month'] . '-' .
					$context[$name . '_day'];
					
		$this->_value = $value;
		
		return parent::isValid($value, $context);
	}

}

