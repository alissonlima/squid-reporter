<?php
class PDA_Validate_Cnpj extends Zend_Validate_Abstract
{
	const INVALID_CNPJ = 'invalidCnpj';

	protected $_messageTemplates = array(
			self::INVALID_CNPJ => "'%value%' is not a valid CNPJ.",
			);

	protected function replace($string)
	{
		return $string = str_replace("/","", str_replace("-","",str_replace(".","",$string)));
	}

	protected function check_fake($string, $length)
	{
		for($i = 0; $i <= 9; $i++) {
			$fake = str_pad(“”, $length, $i);
			if($string === $fake)
				return(1);
		}
	}

	protected function checkCnpj($cnpj)
	{
		$cnpj = $this->replace($cnpj);
		$cnpj = trim($cnpj);
		if(empty($cnpj) || strlen($cnpj) != 14)
		{
			return FALSE;
		}
		else{
			if($this->check_fake($cnpj, 14))
			{

				return FALSE;
			}
			else
			{
				$rev_cnpj = strrev(substr($cnpj, 0, 12));
				for($i = 0; $i <= 11; $i++) 
				{
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
				}
				$rest = $sum % 11;
				if($rest == 0 || $rest == 1)
					$dv1 = 0;
				else
					$dv1 = 11 - $rest; $sub_cnpj = substr($cnpj, 0, 12);
				$rev_cnpj = strrev($sub_cnpj.$dv1);
				unset($sum);
				for($i = 0; $i <= 12; $i++) 
				{
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
				}
				$rest = $sum % 11;
				if($rest == 0 || $rest == 1)
				{
					$dv2 = 0;
				}
				else
				{
					$dv2 = 11 - $rest;
				}	
				if($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
	}



	public function isValid($value)
	{
		$valueString = (string) $value;
		$this->_setValue($valueString);

		if (!$this->checkCnpj($value)) {
			$this->_error(self::INVALID_CNPJ);
			return false;
		}
		return true;
	}
}
