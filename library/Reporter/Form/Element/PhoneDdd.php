<?php

class Reporter_Form_Element_PhoneDdd extends Zend_Form_Element_Xhtml
{
	public $helper = 'formPhoneDdd';

	public function init ()
	{
#		$this->addValidator(new Reporter_Validate_Phone());
	}


	public function isValid ($value, $context = null)
	{
		// ignoring value -- it'll be empty
#		$this->_setValue($value);

		$name = $this->getName();

		$value = $context[$name . '_country'] . $context[$name . '_area'] . $context[$name . '_number'];

		$this->_value = $value;

		return parent::isValid($value, $context);
	}

}

