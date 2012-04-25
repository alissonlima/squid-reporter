<?php

class Relatorio_Model_FiltroDataGroup
{

	public function Build($date_begin, $date_end)
	{
		$pattern = '#([0-9]{4})-([0-9]{2})-([0-9]{2}).*$#sim';
		$begin = preg_replace($pattern, '\1-\2-\3', $date_begin);
		$end = preg_replace($pattern, '\1-\2-\3', $date_end);
               

               $sql = "SELECT ";
               $sql.= "CONCAT('<a href=\"/Relatorio/Group/user-group/usergroup/',grp.name, '/date_begin/{$begin}/date_end/{$end}\">',grp.name,'</a>') AS grupo, ";
               
               $sql.= "SUM(1) AS pags, ";
              
             $sql.= "SUM(reply_size) / (1024 * 1024) AS 'Trafico MB' ";
               $sql.= "FROM access_log AS log ";
               $sql.= "JOIN usuario AS usr ON ( log.username = usr.user) JOIN usergroup AS grp ON (usr.id_group = grp.id) ";
               $sql.= "WHERE log.mime_type = 'text/html' ";
             
               $sql .= "AND  date_time BETWEEN '{$date_begin}' AND '{$date_end}' ";
               
               $sql.= "GROUP BY grp.name ";
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
}
