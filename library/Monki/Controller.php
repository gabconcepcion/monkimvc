<?php

class Monki_Controller
{
    var $view = null; 
    public $noRender = false;
    private $_oDb;
    private $_oSession;
    private $_oRequest;
	
	function __construct($oDb)
	{
        $this->_oDb = $oDb;
		$this->view = new Monki_View();
        
        $this->_oSession = new Monki_Session();
        $this->_oRequest = new Monki_Request();
	}
	
	function setNoRender($bool=true)
	{
		$this->noRender = $bool;
	}
}
