<?php

class Monki_Controller
{
    var $view = null; 
    public $noRender = false;
    private $_oDb;
	
	function __construct($oDb)
	{
        $this->$_oDb = $oDb;
		$this->view = new Monki_View();
	}
	
	function setNoRender($bool=true)
	{
		$this->noRender = $bool;
	}
}
