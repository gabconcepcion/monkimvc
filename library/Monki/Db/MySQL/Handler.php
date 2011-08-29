
<?php

class Monki_Db_MySQL_Handler
{    
        function __construct($params)
        {
                mysql_connect($params['host'], $params['user'], $params['password']) or die(mysql_error());
                mysql_select_db($params['dbname']) or die(mysql_error());
                return $this;
        }
        
        function beginTransaction()
        {
            mysql_query('START TRANSACTION');
        }
        
        function commit()
        {
            mysql_query('COMMIT');
        }
        
        function rollback()
        {
            mysql_query('ROLLBACK');
        }
        
        
        private function cleanString($sql)
        {
                return mysql_real_escape_string($sql);
        }
        
        function query($sql)
        {
            $sql = $this->cleanString($sql);
            $query = mysql_query($sql);
            
            $result = array();
            
            while($row = mysql_fetch_array($query))
                    array_push($result, $row);
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
