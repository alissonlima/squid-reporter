<?php

class Sandbox_Form_Sandbox extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
		#$dos = $this->_getStates();        
		$dos = array();
		$this->addElement('select', 'state', array(
					'label'      => 'UF',
					'required'   => true,
					'multiOptions'     => $dos,
					'filters'    => array('StringTrim')
					));
		$this->addElement('select', 'teste', array(
					'label'      => 'teste',
					'required'   => true,
					'multiOptions'     => $dos,
					'filters'    => array('StringTrim')
					));

    }


}

