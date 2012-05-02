<?php

class Cadastro_Form_Retorn extends Zend_Form
{

	public function init()
	{
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');

		$this->addElement('submit', 'submit', array(
					'ignore'   => true,
					'label'    => 'Retornar',
					'class'     => 'botao_salvar'
					));

                

	}
        

}

