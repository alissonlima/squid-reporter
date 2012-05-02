<?php

class Cadastro_GroupController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
	
		echo "<a href=\"/Cadastro/group/add\">Adicionar Grupo</a>";
                echo "<br>";
                echo "<a href=\"/Cadastro/group/list\">Listar Grupo</a>";
		

	}

	public function addAction()
	{
		// action body
		$form = new Cadastro_Form_Group();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data = $form->getValues();
				
				$do = new Cadastro_Model_DbTable_Grupo();
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
		$do = new Cadastro_Model_DbTable_Grupo();
		$request = $this->getRequest();
		$id = $this->_request->getParam('id');
		$do->delete("id={$id}");
		return $this->_helper->redirector('list');
	}

	public function updateAction()
	{
		$form = new Cadastro_Form_Group();
		$do = new Cadastro_Model_DbTable_Grupo();
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
*/
               		// action body
		$form = new Cadastro_Form_Newgroup();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				
				return $this->_helper->redirector('add');
			}
		}

		$this->view->form = $form;
                
		$sql  = "SELECT ";
 		$sql .= "usergroup.id, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/listuser/name/',name,'\">',name,'</a>') AS name, ";
		$sql .= "usergroup.comment AS Obs, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/update/id',id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/delete/id/',id,'\">apagar</a>') AS apagar ";
		$sql .= "FROM usergroup ";
	
		$grid = new Application_Model_Grid();
		$this->view->grade =  $grid->MontarGrade($sql);
                
         }

         public function listuserAction()
         {

               $usergroup = $this->_request->getParam('name');            

               echo "<h3>Grupo: {$usergroup} </h3>\n";
             # echo "<h3>Usuario: {$usergroup}</h3>\n";
               

               $sql = "SELECT ";
                
                $sql .= "usr.fullname AS 'nome', ";
		$sql .= "usr.user AS 'login', ";
#		$sql .= "usuario.password, ";
		$sql .= "usr.email AS 'e-mail', ";

                $sql .= "DATE_FORMAT(date,'%d/%m/%Y') AS 'Cadastrado em:' , ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Index/update/id/',usr.id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Index/delete/id/',usr.id,'\">apagar</a>') AS apagar ";

               $sql.= "FROM usuario AS usr JOIN usergroup AS grp ON (grp.id = usr.id_group)";
               $sql.= "WHERE name = '{$usergroup}' ";  



	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql); 

               	$form = new Cadastro_Form_retorn();
		$request = $this->getRequest();

		if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				
				return $this->_helper->redirector('list');
			}
		}

		echo $form;


         }

}
