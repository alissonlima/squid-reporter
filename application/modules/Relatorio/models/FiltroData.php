<?php

class Relatorio_Model_FiltroData
{

	public function Build($date_year, $date_month, $date_begin, $date_end)
	{

           
               

               $sql = "SELECT ";
              #$sql.= "log.username  AS name, ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Index/log-user/username/',log.username, '/begin/{$date_begin}/end/{$date_end}\">',log.username,'</a>') AS name, ";
               $sql.= "grp.name AS 'grupo', ";
               $sql.= "SUM(1) AS pags, ";
               $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB' ";
#              $sql.= "SUM(DATE_FORMAT(log.date_time,'%d/%m/%Y')) AS 'tempo gasto' ";
               $sql.= "FROM  access_log AS log ";
               $sql.= "JOIN usuario AS usr ON ( log.username = usr.user) JOIN usergroup AS grp ON (usr.id_group = grp.id) ";
               $sql.= "WHERE log.mime_type = 'text/html' ";
          
               $sql .= "AND  date_time  BETWEEN '{$date_begin}' AND '{$date_end}' ";
              # $sql . ="AND  date_time BETWEEN '{$date_year}' ";
              # $sql .= "AND  date_time = '{$date_month}' ";
	       
               $sql.= "GROUP BY log.username ";
               $sql.= "ORDER BY pags ";
               $sql.= "DESC LIMIT 100 ";


	       $pattern = '#([0-9]{4})-([0-9]{2})-([0-9]{2}).*$#sim';
               $date_begin = preg_replace($pattern, '\3/\2/\1', $date_begin);
	       $date_end = preg_replace($pattern, '\3/\2/\1', $date_end);

	       $grid = new Application_Model_Grid();
              # $buffer = "<h3>Relatorio de {$date_month} - {$date_year}</h3>\n";
	       $buffer = "<h3>período de {$date_begin} - {$date_end}</h3>\n";
	       $buffer .= $grid->MontarGrade($sql);   
    		return $buffer;
	}


        public function logUser( $username, $date_begin, $date_end)
        {      

	      
               echo "<h3>Usuario: {$username}</h3>\n";

                        
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

               $pattern = '#([0-9]{4})-([0-9]{2})-([0-9]{2}).*$#sim';
               $date_begin = preg_replace($pattern, '\3/\2/\1', $date_begin);
	       $date_end = preg_replace($pattern, '\3/\2/\1', $date_end);

	       $grid = new Application_Model_Grid();
	       $buffer = "<h3>período de {$date_begin} - {$date_end}</h3>\n";
	       $buffer .= $grid->MontarGrade($sql);   
    	        return $buffer;
              
               
       }  

       public function logDetailed($detailed, $username, $date_begin, $date_end)
       {
     
              

	       echo "<h3>Date: {$date_begin} - {$date_end}</h3>\n";
               echo "<h3>Usuario: {$username}</h3>\n";
               echo "<h3>url: {$log}</h3>\n";
                        
               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=http://',domain_of_url(`request_url`),'>',domain_of_url(`request_url`),'</a>') AS Sites, ";
 #              $sql.= "SUM(1) AS pags, ";
               $sql.= "TIME_FORMAT(date_time,'%h:%m:%s') AS Time ";
               $sql.= "FROM access_log AS log ";
               $sql.= "WHERE mime_type = 'text/html'";
               $sql.= "AND domain_of_url(`request_url`) = '{$detailed}' "; 
	       $sql.= "AND username = '{$username}' ";                             
	       $sql.= "AND date_time BETWEEN '{$date_begin}' AND '{$date_end}' ";                             
               $sql.= "GROUP BY Time ";
               $sql.= "ORDER BY Sites ";
               $sql.= "DESC LIMIT 100 ";

               $grid = new Application_Model_Grid();
	       echo $grid->MontarGrade($sql);


    }
    

       
}

