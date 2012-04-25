<?php

class Reporter_Validate_Date extends Zend_Validate_Abstract 
{
	const INVALID_DATE = 'invalidDate';
	
	protected $_messages = array(
		self::INVALID_DATE => 'Invalid date.'
	);
	
	public function isValid ($value, $context = null)
	{
		if (date('Y-m-d', strtotime($value)) != $value)
		{
			return false;
		}
		
		return true;
	}
}

