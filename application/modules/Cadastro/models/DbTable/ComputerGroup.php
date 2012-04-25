<?php

class Cadastro_Model_DbTable_ComputerGroup extends Zend_Db_Table_Abstract
{

    protected $_name = 'usergroup';


	public function ListIdComp()
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
				$ret[$line['id']] = $line['name'];
			}
		}

		return $ret;
	}
}

