<?php

class Cadastro_Form_Group extends Zend_Form
{

	public function init()
	{
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->addElement('text', 'name', array(
					'label'      => 'Nome Grupo:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim')
					));
	
					
		$this->addElement('textarea', 'comment', array(
					'label'      => 'Comentarios:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim'),
					));


		




		$this->addElement('submit', 'submit', array(
					'ignore'   => true,
					'label'    => 'enviar',
					'class'     => 'botao_salvar'
					));

                

	}
        

}

