<?php

class Cadastro_IndexController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
	
		
                $sql = "SELECT ";
	        $sql.= "CONCAT('<a href=\"/Cadastro/index/list\">Consultar</a>') AS 'Usuario' , ";
                $sql.= "CONCAT('<a href=\"/Cadastro/group/list\">Consultar</a>') AS 'Grupo', ";
                $sql.= "CONCAT('<a href=\"/Cadastro/computer/list\">Consultar</a>') AS 'Computador' ";
              

		$grid = new Application_Model_Grid();
		echo $grid->MontarGrade($sql);  
		

	}

	public function addAction()
	{
		// action body
		$form = new Cadastro_Form_User();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data = $form->getValues();
			       #$data['password'] = md5($password);
				$do = new Cadastro_Model_DbTable_User();
				$do->insert($data);
				return $this->_helper->redirector('list');
			}
		}

		//echo $form;
                $this->view->form = $form;
	}

	public function deleteAction()
	{
		// action body
		$do = new Cadastro_Model_DbTable_User();
		$request = $this->getRequest();
		$id = $this->_request->getParam('id');
		$do->delete($id);
		return $this->_helper->redirector('list');
	}

	public function updateAction()
	{
		$form = new Cadastro_Form_User();
		$do = new Cadastro_Model_DbTable_User();
		$request = $this->getRequest();
		$id = $this->_request->getParam('id');

		$dados = $do->find($id);
		$dados = $dados[0]->toArray();

		$form->populate($dados);
		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data = $form->getValues();
				#$data['password'] = md5($password);
				$do->update($data);
				return $this->_helper->redirector('list');
			}
		}
		echo $form;
	}
        public function listAction()
        { 
		// action body
		$form = new Cadastro_Form_Newuser();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				
				return $this->_helper->redirector('add');
			}
		}

	        $this->view->form = $form;
                
	
		$sql = "SELECT ";
#                $sql .= "CONCAT('<a href=\"/Cadastro/Index/add/''\">Novo</a>') AS 'Cadastrar novo usuario', ";
#		$sql .= "usuario.id, ";
		$sql .= "usuario.fullname AS 'nome', ";
		$sql .= "usuario.user AS 'login', ";
#		$sql .= "usuario.password, ";
		$sql .= "usuario.email AS 'e-mail', ";
		$sql .= "usergroup.name AS grupo, ";
                $sql.="DATE_FORMAT(date,'%d/%m/%Y') AS 'Cadastrado em:' , ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Index/update/id/',usuario.id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Index/delete/id/',usuario.id,'\">apagar</a>') AS apagar ";
		$sql .= "FROM `usuario` JOIN usergroup ON ( usuario.id_group = usergroup.id) ";
	
		$grid = new Application_Model_Grid();
		$this->view->grade =  $grid->MontarGrade($sql);
                
    }

}
