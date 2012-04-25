<?php

class Relatorio_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body 

/*
		$sql = "SELECT ";
	        $sql.= "CONCAT('<a href=\"/Relatorio/Index/date-day/\">Diario</a>')  AS 'Relatorio diario', ";
                $sql.= "CONCAT('<a href=\"/Relatorio/Index/date-day/\">Semanal</a>') AS 'Relatorio Semanal', ";
                $sql.= "CONCAT('<a href=\"/Relatorio/Index/date-day/\">Mensal</a>')  AS 'Relatorio Mensal' ";

		$grid = new Application_Model_Grid();
		echo $grid->MontarGrade($sql);   
              
*/
		$form = new Relatorio_Form_Filtro();
		echo $form;

    }

    public function dateDayAction()
    {
       

              $sql = "SELECT " ; 
#             $sql.= "ORDER BY (DATE_FORMAT(date_time,'%d/%m/%Y')) AS id, ";
#             $sql.= "DATE_FORMAT(date_time,'%d/%m/%Y') AS dia, ";
              $sql.= "CONCAT('<a href=\"/Relatorio/Index/access-day/date/', DATE_FORMAT(date_time,'%Y-%m-%d') ,'\">',DATE_FORMAT(date_time,'%d/%m/%Y'),'</a>') AS Relatorios ";
       
              $sql.= "FROM `access_log`"; 
              $sql.= "GROUP BY Relatorios";
      
              $grid = new Application_Model_Grid();
	      echo $grid->MontarGrade($sql); 


    }

    public function accessAction()
    {
               $sql = "SELECT ";
               $sql.= "CONCAT('<SELECT><option>',DATE_FORMAT(date_time,'%d/%m/%Y'),'</SELECT>') AS entre, ";
               $sql.= "CONCAT('<SELECT><option>',DATE_FORMAT(date_time,'%d/%m/%Y'),'</SELECT>') AS ate ";
               
               $sql.= "FROM  access_log AS log";
          
              
	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);   
    

    }

    
    public function accessDayAction()
    {
                
               $date = $this->_request->getParam('date');
               $time_begin = "{$date} 00:00:00";
	       $time_end = "{$date} 23:59:59";
	       echo "<h3>Data: {$date}</h3>\n";

               $sql = "SELECT ";
              #$sql.= "log.username  AS name, ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-user/username/',log.username, '/date/{$date}\">',log.username,'</a>') AS name, ";
               $sql.= "grp.name AS 'grupo', ";
               $sql.= "SUM(1) AS pags, ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB' ";
#               $sql.= "SUM(DATE_FORMAT(log.date_time,'%d/%m/%Y')) AS 'tempo gasto' ";
               $sql.= "FROM  access_log AS log ";
               $sql.= "JOIN usuario AS usr ON ( log.username = usr.user) JOIN usergroup AS grp ON (usr.id_group = grp.id) ";
               $sql.= "WHERE log.mime_type = 'text/html' ";
               
               if($date)
	       {
		$sql .= "AND date_time BETWEEN '{$time_begin}' AND '{$time_end}' ";
	       }
               /* if($date)
	       {
		$sql .= "AND date_time BETWEEN '{$date_begin}' AND '{$date_end}' ";
	       */
               $sql.= "GROUP BY log.username ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";


	       $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);   
              
    }

    public function accessWeekAction()
    {
        // action body
    }

    public function logUserAction()
    {
               $username = $this->_request->getParam('username');
               $date = $this->_request->getParam('date');
               $usergroup = $this->_request->getParam('group');
               $time_begin = "{$date} 00:00:00";
	       $time_end = "{$date} 23:59:59";

	       echo "<h3>Date: {$date}</h3>\n";
               echo "<h3>Usuario: {$username}</h3>\n";
               echo "<h3>Usuario: {$usergroup}</h3>\n";
                        
               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-detailed/detailed/',domain_of_url(`request_url`),'/date/{$date}/username/{$username}\">detailed</a>') AS detailed, ";
               $sql.= "CONCAT('<a href=http://',domain_of_url(`request_url`),'>',domain_of_url(`request_url`),'</a>') AS Sites, ";
               $sql.= "SUM(1) AS pags, ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB', ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time, ";
               $sql.= "CONCAT('<a href=\"/Cadastro/Computer/list-log/ip/',log.client_src_ip_addr,' \">',log.client_src_ip_addr,'</a>') AS 'IP Local' ";
               $sql.= "FROM access_log AS log, usergroup ";
               $sql.= "WHERE mime_type = 'text/html'";
	       $sql.= "AND username = '{$username}' "; 
               $sql.= "AND name = '{$usergroup}' ";                             
	       $sql.= "AND date_time BETWEEN '{$time_begin}' AND '{$time_end}' ";                             

               $sql.= "GROUP BY Sites ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";

               $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql); 
    } 
    
     public function logDetailedAction()
    {
     
               $log = $this->_request->getParam('detailed');
               $username = $this->_request->getParam('username');
               $date = $this->_request->getParam('date');
               $time_begin = "{$date} 00:00:00";
	       $time_end =   "{$date} 23:59:59";

	       echo "<h3>Date: {$date}</h3>\n";
               echo "<h3>Usuario: {$username}</h3>\n";
               echo "<h3>url: {$log}</h3>\n";
                        
               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=http://',domain_of_url(`request_url`),'>',domain_of_url(`request_url`),'</a>') AS Sites, ";
 #              $sql.= "SUM(1) AS pags, ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time ";
               $sql.= "FROM access_log AS log ";
               $sql.= "WHERE mime_type = 'text/html'";
               $sql.= "AND domain_of_url(`request_url`) = '{$log}' "; 
	       $sql.= "AND username = '{$username}' ";                             
	       $sql.= "AND date_time BETWEEN '{$time_begin}' AND '{$time_end}' ";                             
               $sql.= "GROUP BY Time ";
               $sql.= "ORDER BY Sites ";
               $sql.= "DESC LIMIT 100 ";

               $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);


    }
}


