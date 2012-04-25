<?php

class Reporter_Form_Element_Time extends Zend_Form_Element_Xhtml
{
	public $helper = 'formTime';

	public function init ()
	{
		$this->addValidator(new Reporter_Validate_Time());
	}
	
	public function isValid ($value, $context = null)
	{
		// ignoring value -- it'll be empty
		
		$name = $this->getName();

		$value = $context[$name . '_hour'] . '-' .$context[$name . '_min'];
					
		$this->_value = $value;
		
		return parent::isValid($value, $context);
	}

}

