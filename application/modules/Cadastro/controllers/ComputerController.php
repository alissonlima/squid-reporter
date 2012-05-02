<?php

class Cadastro_ComputerController extends Zend_Controller_Action
{

  public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
	
		echo "<a href=\"/Cadastro/computer/add\">Adicionar Computador</a>";
                echo "<br>";
                echo "<a href=\"/Cadastro/computer/list\">Listar Computador</a>";
		

	}

	public function addAction()
	{
		// action body
		$form = new Cadastro_Form_Computer();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data = $form->getValues();
				
				$do = new Cadastro_Model_DbTable_Computer();
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
		$do = new Cadastro_Model_DbTable_Computer();
		$request = $this->getRequest();
		$id = $this->_request->getParam('id');
		$do->delete("id={$id}");
		return $this->_helper->redirector('list');
	}

	public function updateAction()
	{
		$form = new Cadastro_Form_Computer();
		$do = new Cadastro_Model_DbTable_Computer();
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
				//$data['password'] = md5($password);
				$do->update($data);
				return $this->_helper->redirector('list');
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

		$sql  = "SELECT ";
 	        $sql .= "computer.id AS ID, ";
		$sql .= "computer.name AS Modelo, ";
		$sql .= "computer.ip AS IP, ";
                $sql .= "usergroup.name AS Grupo, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/computer/update/id/',id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/computer/delete/id/',id,'\">apagar</a>') AS apagar ";
		$sql .= "FROM `computer` JOIN usergroup ON ( computer.id_group = usergroup.id ) ";
*/

                		// action body
		$form = new Cadastro_Form_Newcomputer();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				
				return $this->_helper->redirector('add');
			}
		}

		$this->view->form = $form;

                $sql  = " SELECT ";
                $sql .= " cpu.name AS Modelo, ";
                $sql .= " cpu.ip AS IP, ";
                $sql .= " usr.user AS name, ";
                $sql .= " grp.name AS grupo, ";
                $sql .= "CONCAT('<a href=\"/Cadastro/Computer/update/id/',cpu.id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Computer/delete/id/',cpu.id,'\">apagar</a>') AS apagar ";
                $sql .= " FROM computer AS cpu JOIN usuario AS usr ON ( cpu.id_user = usr.id) JOIN usergroup AS grp ON (cpu.id_group = grp.id ) ";
               

		$grid = new Application_Model_Grid();
		$this->view->grade =  $grid->MontarGrade($sql);
           
    }
    public function listLogAction()
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

		$sql  = "SELECT ";
 	        $sql .= "computer.id AS ID, ";
		$sql .= "computer.name AS Modelo, ";
		$sql .= "computer.ip AS IP, ";
                $sql .= "usergroup.name AS Grupo, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/computer/update/id/',id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/computer/delete/id/',id,'\">apagar</a>') AS apagar ";
		$sql .= "FROM `computer` JOIN usergroup ON ( computer.id_group = usergroup.id ) ";
*/


                $ip = $this->_request->getParam('ip');

	        echo "<h3>IP: {$ip}</h3>\n";
                
                $sql  = " SELECT ";
                $sql .= " cpu.id AS IP, ";
                $sql .= " cpu.name AS Modelo, ";
                $sql .= " usr.user AS name, ";
                $sql .= " grp.name AS grupo ";                
                $sql .= " FROM computer AS cpu JOIN usuario AS usr ON ( cpu.id_user = usr.id) JOIN usergroup AS grp ON (cpu.id_group = grp.id ) ";
                $sql.= "WHERE cpu.ip = '{$ip}' ";

		$grid = new Application_Model_Grid();
		$this->view->grade =  $grid->MontarGrade($sql);
                
    }

}
