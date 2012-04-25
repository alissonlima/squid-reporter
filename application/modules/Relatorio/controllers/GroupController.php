
<?php

class Relatorio_GroupController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
        // action body 


	      $form = new Relatorio_Form_FiltroGroup();
		echo $form;
                $request = $this->getRequest();
                if ($this->getRequest()->isPost()) 
		{
			if ($form->isValid($request->getPost())) 
			{
				$data 		= $form->getValues();
				$date_begin 	= $form->getValue('date_begin');	
				$date_end 	= $form->getValue('date_end');
                                $date_month     = $form->getValue('date_month');
                                $date_year      = $form->getValue('date_year');
	
				#$this->insert('access-day');
				$filtro = new Relatorio_Model_FiltroDataGroup();
                               # echo $filtro->Build($date_month, $date_year);
				echo $filtro->Build($date_begin, $date_end);
			}
		}

    }




    
    public function userGroupAction()
    {
                
               $usergroup = $this->_request->getParam('usergroup');            
               $date_begin = $this->_request->getParam('date_begin');
               $date_end = $this->_request->getParam('date_end');
               $date_begin = "{$date_begin} 00:00:00";
	       $date_end = "{$date_end} 23:59:59";

	       echo "<h3>Date: {$date_begin} - {$date_end}</h3>\n";
               echo "<h3>Usuario: {$usergroup}</h3>\n";
             #  echo "<h3>Usuario: {$usergroup}</h3>\n";
               

               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-user/username/',log.username, '/date_begin/{$date_begin}/date_end/{$date_end}/group/{$usergroup}\">',log.username,'</a>') AS name, "; 
#              $sql.= "grp.name AS 'grupo' ";
               $sql.= "SUM(1) AS pags,  ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB', ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time, ";
               $sql.= "CONCAT('<a href=\"/Cadastro/Computer/list-log/ip/',log.client_src_ip_addr,' \">',log.client_src_ip_addr,'</a>') AS 'IP Local' ";
               $sql.= "FROM usuario AS usr JOIN access_log AS log ON (usr.user = log.username) JOIN usergroup AS grp ON (grp.id = usr.id_group)";
               $sql.= "WHERE log.mime_type = 'text/html' ";
               $sql.= "AND name = '{$usergroup}' ";                             
	       $sql.= "AND date_time BETWEEN '{$date_begin}' AND '{$date_end}' ";  
               $sql.= "GROUP BY log.username ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";


	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);   
              
    }
}
