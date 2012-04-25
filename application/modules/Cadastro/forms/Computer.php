<?php

class Cadastro_Form_Computer extends Zend_Form
{

	public function init()
	{
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->addElement('text', 'name', array(
					'label'      => 'modelo:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim')
					));

		$this->addElement('text', 'ip', array(
					'label'      => 'IP ADDR:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim')
                                        

					));
	

		$do = new Cadastro_Model_DbTable_ComputerGroup();
		$dos = $do->ListIdComp();
		$dos = array('0'=>'Selecione um grupo') + $dos;
		$this->addElement('select', 'id_group', array(
		#$this->addElement('radio', 'id_group', array(
					'label'      => 'grupo:',
					'required'   => true,
					'multiOptions'     => $dos,
					'filters'    => array('StringTrim')
					));

                $do = new Cadastro_Model_DbTable_UserComp();
		$dos = $do->ListIdUser();
		$dos = array('0'=>'Usuarios') + $dos;
		$this->addElement('select', 'id_user', array(
		#$this->addElement('radio', 'id_group', array(
					'label'      => 'usuario:',
					'required'   => true,
					'multiOptions'     => $dos,
					'filters'    => array('StringTrim')
					));




		$this->addElement('submit', 'submit', array(
					'ignore'   => true,
					'label'    => 'enviar',
					'class'     => 'botao_salvar'
					));

                

	}
        

}

