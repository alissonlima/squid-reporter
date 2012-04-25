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
	        $sql.= "CONCAT('<a href=\"/Cadastro/index/add\">Novo</a>') AS 'Cadastrar Usuario' , ";
                $sql.= "CONCAT('<a href=\"/Cadastro/index/list\">Lista</a>') AS 'Listar Usuario' ";
              

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
				return $this->_helper->redirector('index');
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
				return $this->_helper->redirector('index');
			}
		}
		echo $form;
	}
        public function listAction()
        {
/*
		$sql = "SELECT ";
		$sql .= "usuario.id, ";
		$sql .= "usuario.fullname, ";
		$sql .= "usuario.user, ";
		$sql .= "usuario.password, ";
		$sql .= "usuario.email, ";
		$sql .= "usergroup.name AS grupo ";
		$sql .= "FROM `usuario` JOIN usergroup ON ( usuario.id_group = usergroup.id) ";
	
                $db = Zend_Db_Table::getDefaultAdapter();
                $result = $db->fetchAll($sql);

		if($result)
		{
			echo "<a href=\"/Cadastro/index/add\">adicionar</a>";
			echo "<table border='1'>\n<thead>\n<tr>\n";
                        echo "<td>ID</td>\n";
			echo "<td>nome</td>\n";
			echo "<td>login</td>\n";
			echo "<td>grupo</td>\n";
			echo "<td>editar</td>\n";
			echo "<td>apagar</td>\n";
			echo "</tr></thead>\n";
			foreach($result as $line)
			{
				echo "<tr>\n";
                                echo "<td>{$line['id']}</td>\n";
				echo "<td>{$line['fullname']}</td>\n";
				echo "<td>{$line['user']}</td>\n";
				echo "<td>{$line['grupo']}</td>\n";
				echo "<td><a href=\"/Cadastro/index/update/id/{$line['id']}\">Editar</a></td>\n";
				echo "<td><a href=\"/Cadastro/index/delete/id/{$line['id']}\">apagar</a></td>\n";
				echo "</tr>\n";
			}
                        
			echo "</table>\n";
                        echo "<a href=\"/Cadastro/index/index\">Retornar</a>";

		}
*/
		$sql = "SELECT ";
                $sql .= "CONCAT('<a href=\"/Cadastro/Index/add/''\">Novo</a>') AS 'Cadastrar novo usuario', ";
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
                echo "<a href=\"/Cadastro/Index/index\">Retornar</a>";
    }

}
