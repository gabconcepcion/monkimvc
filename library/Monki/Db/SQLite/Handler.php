<?php

class Monki_Db_SQLite_Handler
{
	private $_oDb;
	
	function __construct($file)
	{
		$this->_oDb = new SQLite3($file);
        return $this;
	}
	
	function escapeString($sql)
	{
		return SQLite3::escapeString($sql);
	}
	
	function exec($sql)
	{
		$sql = self::escapeString($sql);
		SQLite3::exec($sql);
		return true;
	}
	
	function fetchAll($sql)
	{                    
		$sql = self::escapeString($sql);
		
		$aResult = array();
		
		$oQuery = $this->_oDb->query($sql);
		while ($aRow = $oQuery->fetchArray()) {
		    array_push($aResult, $aRow);
		}
		
		return $aResult;     
	}
	
	function fetchRow($sql, $iRow=0)
	{                         
		$sql = self::escapeString($sql);
		$aResult = $this->fetchAll($sql);
		return $aResult[$iRow];
	}
}
