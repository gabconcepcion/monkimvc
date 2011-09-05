<?php

class Monki_Db_SQLite_Handler
{
	private $_oDb;
	
	function __construct($file)
	{
        try
    	{
        	if( !$this->_oDb = new SQLite3($file) )
            {
                if( !$this->_oDb =SQLiteDatabase($file) )
                {
                    throw new Exception('SQLite is not supported on this server!');
                }
            }   
        
            return $this;
    	}
        catch($e)
        {
            throw($e);
        }
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
