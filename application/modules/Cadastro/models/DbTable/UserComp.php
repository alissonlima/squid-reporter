<?php

class Cadastro_Model_DbTable_UserComp extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario';


	public function ListIdUser()
	{
                $sql = "SELECT * FROM {$this->_name}";
#		echo $sql;
#		return;
                $db = Zend_Db_Table::getDefaultAdapter();
                $result = $db->fetchAll($sql);

		$ret = array();
		if($result)
		{
			foreach($result as $line)
			{
				$ret[$line['id']] = $line['user'];
			}
		}

		return $ret;
	}
}
