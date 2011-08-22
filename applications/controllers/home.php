<?php

class Home extends Monki_Controller
{    
    function __construct($_oDb=null)
    {
            $this->_oDb = $_oDb;
    }
    
	function index()
	{
		Monki_Loader::loadClass('User');
		
		$oUser = new User();
		$oUser->setValue('name', 'Hello World');
		
		$this->view->data = $oUser->getValue('name');
		
		$this->view->admin_constant = Constants::USERGROUP_ADMIN; 
		$this->view->fruits = array('banana', 'bonana'); 
	}
}
