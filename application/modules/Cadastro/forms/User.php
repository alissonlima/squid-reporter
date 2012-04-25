<?php

class Cadastro_Form_User extends Zend_Form
{

	public function init()
	{
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('post');
		$this->addElement('text', 'user', array(
					'label'      => 'login:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim')
					));
		$this->addElement('password', 'password', array(
					'label'      => 'senha:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim')
					));
		$this->addElement('text', 'fullname', array(
					'label'      => 'nome:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim'),
					));

		$this->addElement('text', 'email', array(
					'label'      => 'e-mail:',
					'required'   => true,
					'size'           => 50,
					'class'     => 'form_input',
					'filters'    => array('StringTrim'),
					'validators'    => array(new Zend_Validate_EmailAddress())
					));

		$do = new Cadastro_Model_DbTable_Group();
		$dos = $do->ListIdName();
		$dos = array('0'=>'Selecione um grupo') + $dos;
		$this->addElement('select', 'id_group', array(
		#$this->addElement('radio', 'id_group', array(
					'label'      => 'grupo:',
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

