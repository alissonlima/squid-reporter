
<?php

class Relatorio_GroupController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
        // action body 


	      $sql = "SELECT ";
	      $sql.= "CONCAT('<a href=\"/Relatorio/Group/date-day/\">Diario</a>') AS Relatorio_diario, ";
              $sql.= "CONCAT('<a href=\"/Relatorio/Group/date-day/\">Semanal</a>') AS Relatorio_Semanal, ";
              $sql.= "CONCAT('<a href=\"/Relatorio/Group/date-day/\">Mensal</a>') AS Relatorio_Mensal ";

	      $grid = new Application_Model_Grid();
	      echo $grid->MontarGrade($sql);   
              

    }

    public function dateDayAction()
    {
       

              $sql = "SELECT " ;
#             $sql.= "DATE_FORMAT(date_time,'%d/%m/%Y') AS dia, ";
              $sql.= "CONCAT('<a href=\"/Relatorio/Group/access-day/date/', DATE_FORMAT(date_time,'%Y-%m-%d') ,'\">',DATE_FORMAT(date_time,'%d/%m/%Y'),'</a>') AS Relatorios_grupos ";
       
              $sql.= "FROM `access_log`"; 
              $sql.= "GROUP BY Relatorios_grupos ";
      
              $grid = new Application_Model_Grid();
	      echo $grid->MontarGrade($sql); 


    }

    public function accessDayAction()
    {

               $date = $this->_request->getParam('date');
	       echo "<h2>{$date}</h2>\n";
	       $time_begin = "{$date} 00:00:00";
	       $time_end = "{$date} 23:59:59";

               $sql = "SELECT ";
               $sql.= " CONCAT('<a href=\"/Relatorio/Group/user-group/usergroup/',grp.name, '/date/{$date}\">',grp.name,'</a>') AS grupo, ";
               $sql.= "SUM(1) AS pags ";
#              $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB' ";
               $sql.= "FROM access_log AS log ";
               $sql.= "JOIN usuario AS usr ON ( log.username = usr.user) JOIN usergroup AS grp ON (usr.id_group = grp.id) ";
               $sql.= "WHERE log.mime_type = 'text/html' ";
  
               if($date)
	       {
		$sql .= "AND date_time BETWEEN '{$time_begin}' AND '{$time_end}' ";
	       }
               $sql.= "GROUP BY grp.name ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";


	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);   
              
    }
    
    public function userGroupAction()
    {
                
               $usergroup = $this->_request->getParam('usergroup');
               $date = $this->_request->getParam('date');
               $time_begin = "{$date} 00:00:00";
	       $time_end = "{$date} 23:59:59";
	       echo "<h2>Date:  {$date}</h2>\n";
               echo "<h2>Grupo: {$usergroup}</h2>\n";

               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-user/username/',log.username, '/date/{$date}/group/{$usergroup}\">',log.username,'</a>') AS name, "; 
#              $sql.= "grp.name AS 'grupo' ";
               $sql.= "SUM(1) AS pags,  ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB', ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time, ";
               $sql.= "CONCAT('<a href=\"/Cadastro/Computer/list-log/ip/',log.client_src_ip_addr,' \">',log.client_src_ip_addr,'</a>') AS 'IP Local' ";
               $sql.= "FROM usuario AS usr JOIN access_log AS log ON (usr.user = log.username) JOIN usergroup AS grp ON (grp.id = usr.id_group)";
               $sql.= "WHERE log.mime_type = 'text/html' ";
               $sql.= "AND name = '{$usergroup}' ";                             
	       $sql.= "AND date_time BETWEEN '{$time_begin}' AND '{$time_end}' ";  
               $sql.= "GROUP BY log.username ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";


	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);   
              
    }
}
