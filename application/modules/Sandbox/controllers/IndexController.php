<?php

class Sandbox_IndexController extends Zend_Controller_Action
{

	protected function _getStates()
	{
		$states = array(
				"" => "Selectione um Estado",
				"AC" => "Acre",
				"AL" => "Alagoas",
				"AM" => "Amazonas",
				"AP" => "Amapá",
				"BA" => "Bahia",
				"CE" => "Ceará",
				"DF" => "Distrito Federal",
				"ES" => "Espírito Santo",
				"GO" => "Goiás",
				"MA" => "Maranhão",
				"MG" => "Minas Gerais",
				"MS" => "Mato Grosso do Sul",
				"MT" => "Mato Grosso",
				"PA" => "Pará",
				"PB" => "Paraíba",
				"PE" => "Pernambuco",
				"PI" => "Piauí",
				"PR" => "Paraná",
				"RJ" => "Rio de Janeiro",
				"RN" => "Rio Grande do Norte",
				"RO" => "Rondônia",
				"RR" => "Roraima",
				"RS" => "Rio Grande do Sul",
				"SC" => "Santa Catarina",
				"SE" => "Sergipe",
				"SP" => "São Paulo",
				"TO" => "Tocantins",

				);
		return $states;
	}



	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		// action body
		$form = new Sandbox_Form_Sandbox();
		echo $form;
	}

	public function pegarjsonAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$states = $this->_getStates();
		$options = '';
		
		$uf = $this->_request->getParam('uf');
		if($uf)
		{
			echo "<option value=''></option><option value=''>VC SELECIONOU :: {$states[$uf]}</option>";
			return true;
		}

		foreach($states as $key => $value)
		{
			$options .= "<option value=\"{$key}\">{$value}</option>\n";
		}
		echo $options;
	}


}



