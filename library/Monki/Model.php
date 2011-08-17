<?php

class Monki_Model
{
	var $_data = array();
	
	function setValue($key, $value)
	{
		$this->_data[$key] = $value;
	}
	
	function getValue($key)
	{
		if(!isset($this->_data[$key])) return null;
		
		return $this->_data[$key];
	}
}
