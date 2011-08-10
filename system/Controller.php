<?php

class Controller
{
	var $view = null; 
	
	function __construct()
	{
		$this->view = new View();
	}
}
