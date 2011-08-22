<?php

class Monki_Db_MySQL_Handler
{    
    function __construct($params)
    {
        mysql_connect($params['host'], $params['user'], $params['password']) or die(mysql_error());
        mysql_select_db($params['dbname']) or die(mysql_error());
        return $this;
    }
    
    private function cleanString($sql)
    {
        return mysql_real_escape_string($sql);
    }
    
    function query($sql)
    {
        $sql = cleanString($sql);
    	$query = mysql_query($sql);
    	$result = mysql_fetch_array($query);
        return $result;
    }
    
	function fetchAll($sql)
	{
		$result = $this->query($sql);
		
		return $result;
	}
	
	function fetchRow($sql, $row=0)
	{
		$result = $this->fetchAll($sql);
		return $result[$row];
	}
}
