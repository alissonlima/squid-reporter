<?php
class Reporter_Acl_ReporterAcl extends Zend_Acl 
{
	public function __construct() 
	{

		$this->addRole(new Zend_Acl_Role('user'));
#		$this->addRole(new Zend_Acl_Role('admin'));
		$this->addRole(new Zend_Acl_Role('admin'), 'user');
		$this->addRole(new Zend_Acl_Role('devs'), 'admin');
		$this->addRole(new Zend_Acl_Role('guest'));



		$this->add(new Zend_Acl_Resource('user_area'));
		$this->add(new Zend_Acl_Resource('admin_area'));
		$this->add(new Zend_Acl_Resource('devs_area'));
		$this->add(new Zend_Acl_Resource('guest_area'));

		$this->allow('user', 'user_area');
		$this->allow('devs', 'devs_area');
		$this->allow('admin', 'admin_area');
		$this->allow('guest', 'guest_area');
#		$this->allow('admin_client', 'adm_client');
	}

}

