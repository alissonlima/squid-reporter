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
				$filtro = new Relatorio_Model_FiltroData();
                               # echo $filtro->Build($date_month, $date_year);
				echo $filtro->Build($date_year, $date_month, $date_begin, $date_end);
			}
		}


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


    public function logUserAction()
    {

               $username = $this->_request->getParam('username');
               $usergroup = $this->_request->getParam('group');            
               $date_begin = $this->_request->getParam('date_begin');
               $date_end = $this->_request->getParam('date_end');
               $date_begin = "{$date_begin} 00:00:00";
	       $date_end = "{$date_end} 23:59:59";

	       echo "<h3>Date: {$date_begin} - {$date_end}</h3>\n";
               echo "<h3>Usuario: {$username}</h3>\n";
             #  echo "<h3>Usuario: {$usergroup}</h3>\n";
                        
               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-detailed/detailed/',domain_of_url(`request_url`),'/username/{$username}/date_begin/{$date_begin}/date_end/{$date_end}\">detailed</a>') AS detailed, ";

 
               $sql.= "CONCAT('<a href=http://',domain_of_url(`request_url`),'>',domain_of_url(`request_url`),'</a>') AS Sites, ";
               $sql.= "SUM(1) AS pags, ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB', ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time, ";
               $sql.= "CONCAT('<a href=\"/Cadastro/Computer/list-log/ip/',log.client_src_ip_addr,' \">',log.client_src_ip_addr,'</a>') AS 'IP Local' ";
               $sql.= "FROM access_log AS log, usergroup ";
               $sql.= "WHERE mime_type = 'text/html'";
	       $sql.= "AND username = '{$username}' "; 
               $sql .= "AND date_time BETWEEN '{$date_begin}'  AND'{$date_end}' ";
             #  $sql.= "AND name = '{$usergroup}' ";                            
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
               $date_begin = $this->_request->getParam('date_begin');
               $date_end = $this->_request->getParam('date_end');
               $date_begin = "{$date_begin} 00:00:00";
	       $date_end = "{$date_end} 23:59:59";

	       echo "<h3>Date: {$date_begin} - {$date_end}</h3>\n";
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
	       $sql.= "AND date_time BETWEEN '{$date_begin}' AND '{$date_end}' ";                             
               $sql.= "GROUP BY Time ";
               $sql.= "ORDER BY Sites ";
               $sql.= "DESC LIMIT 100 ";

               $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);


    }
}


