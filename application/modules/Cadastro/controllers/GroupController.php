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
				return $this->_helper->redirector('index');
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
		$sql  = "SELECT ";
 		$sql .= "usergroup.id, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/list-user/username/',id,'\">',usergroup.name,'</a>') AS name, ";
		$sql .= "usergroup.comment AS Obs, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/update/id',id,'\">editar</a>') AS editar, ";
		$sql .= "CONCAT('<a href=\"/Cadastro/Group/delete/id/',id,'\">apagar</a>') AS apagar ";
		$sql .= "FROM `usergroup` ";
	
		$grid = new Application_Model_Grid();
		$this->view->grade =  $grid->MontarGrade($sql);
                echo "<a href=\"/Cadastro/Group/index\">Retornar</a>";
         }

         public function listUserAction()
         {

               $username = $this->_request->getParam('id');
               echo "<h2>Usuario: {$username}</h2>\n";
                        
               $sql = "SELECT ";
               $sql.= "id AS id, ";
               $sql.= "usuario.user AS usuario";

               $sql .= "FROM `usergroup` ";
              
	       $sql .= "WHERE id_group = '{$username}' ";                             
	       
               $sql.= "GROUP BY usuario ";
               $sql.= "ORDER BY id ";
               $sql.= "DESC LIMIT 100 ";

               $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql); 



         }

}
