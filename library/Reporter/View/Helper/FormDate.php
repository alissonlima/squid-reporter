<?php

class PDA_View_Helper_FormDate extends Zend_View_Helper_FormElement 
{
	public function formDate ($name, $value = null, $attribs = null)
	{
		// if the element is rendered without a value,
		// show today's date

		if ($value === null)
		{
			$value = date('Y-m-d');
		}

		list($year, $month, $day) = explode('-', $value);

		// build select options

		$date = new Zend_Date();

		$dayOptions = array();
		for ($i = 1; $i < 32; $i ++)
		{
			$idx = str_pad($i, 2, '0', STR_PAD_LEFT);
			$dayOptions[$idx] = str_pad($i, 2, '0', STR_PAD_LEFT);
		}

		$monthOptions = array();
		for ($i = 1; $i < 13; $i ++)
		{
			$date->set($i, Zend_Date::MONTH);
			$idx = str_pad($i, 2, '0', STR_PAD_LEFT);
			$monthOptions[$idx] = $date->toString('MMMM');
		}

		$yearOptions = array();
		for ($i = 1930; $i < 2031; $i ++)
		{
			$yearOptions[$i] = $i;
		}

		// return the 3 selects separated by -

		return
			$this->view->formSelect(
					$name . '_day',
					$day,
					$attribs,
					$dayOptions) . ' - ' .
			$this->view->formSelect(
					$name . '_month',
					$month,
					$attribs,
					$monthOptions) . ' - ' .
			$this->view->formSelect(
					$name . '_year',
					$year,
					$attribs,
					$yearOptions			
					);
	}
}

