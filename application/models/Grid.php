<?php

class Application_Model_Grid
{

	protected $_buffer;
	protected $_db_adapter = null;

	public function __construct()
	{
		$this->_buffer .= ""; 
	}


	public function setTitle($titulo)
	{
		$this->_buffer .= "<h2>{$titulo}</h2>\n"; 
	}

	public function setDbAdapter($db)
	{
		$this->_db_adapter = $db;
	}

	public function MontarGrade($sql, $titulo="")
	{
		$buffer = "";

		if($titulo != "")
		{
			$this->setTitle($titulo);
		}
		if(is_null($this->_db_adapter))
		{
			$db = Zend_Db_Table::getDefaultAdapter(); 
		}
		else
		{
			$db = $this->_db_adapter;
		}
		$linhas = $db->fetchAll($sql);

#		Zend_Debug::Dump($linhas);

		if($linhas)
		{
			$buffer = "<table class=\"report\">\n<thead>\n";
			foreach($linhas[0] as $chave => $valor)
			{
				$buffer .= "\t<td>{$chave}</td>\n";
			}
			$buffer .= "</thead>\n<tbody >\n";


			foreach($linhas as $linha)
			{
				$buffer .= "<tr>\n";
				foreach($linha as $coluna)
				{
					$buffer .= "\t<td>{$coluna}</td>\n";
				}
				$buffer .= "</tr>\n";
			}
			$buffer .= "</tbody>\n";
			$buffer .= "</table>\n";
		}

		$this->_buffer .= $buffer;
		return $this->_buffer;
	}

	public function Montar()
	{
		return $this->_buffer;
	}
}

