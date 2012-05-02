<?php

class Relatorio_Model_FiltroUser
{

public function logUser( $username, $date_begin, $date_end)
    {

               $username = "{$username}";
               
               $date_begin = "{$date_begin}";
               $date_end = "{$date_end}";
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

    

}
