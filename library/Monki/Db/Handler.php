<?php

class Monki_Db_Handler
{
	public $result = null;
	public $sql = null;
	
	function fetchRow($sql, $pos=0)
	{
		$result = $this->fetchAll($sql);
		return $result[$pos];
	}
	
	function fetchAll($sql)
	{
		if($this->sql==$sql)
			return $this->result;
		
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);
		
		$this->sql = $sql;
		$this->query = $result;
		
		return $result;
	}
}