<?php

class Reporter_Form_Element_Phone extends Zend_Form_Element_Xhtml
{
	public $helper = 'formPhone';
	public $ddi = null;
	public $ddd = null;
	public $number = null;

	public function setDdi($ddi)
	{
		$this->ddi = $ddi;
	}

	public function setDdd($ddd)
	{
		$this->ddd = $ddd;
	}

	public function init ()
	{
		$this->addValidator(new Reporter_Validate_Phone());
	}

	
	public function isValid ($value, $context = null)
	{
		// ignoring value -- it'll be empty
		$name = $this->getName();
		
		Zend_Debug::Dump($context);
		
		if(strlen($context[$name . '_ddi']) != 2)
		{
			#echo "H1: DDI";
			#return false;
		}

		if(strlen($context[$name . '_ddd']) != 2)
		{
			#echo "H1: DDD";
			#return false;
		}

		if(strlen($context[$name . '_number']) != 8)
		{
			#echo "H1: Number";
			#return false;
		}

		$value = $context[$name . '_ddi'] . $context[$name . '_ddd'] . $context[$name . '_number'];
					
		$this->_value = $value;
		
		return parent::isValid($value, $context);
	}
}

