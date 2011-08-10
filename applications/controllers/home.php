<?php

class Home extends Controller
{
	function index()
	{
		Loader::loadModel('User');
		
		$oUser = new User();
		$oUser->setValue('name', 'Hello World');
		
		$this->view->data = $oUser->getValue('name');
		
		$this->view->admin_constant = Constants::USERGROUP_ADMIN; 
		$this->view->fruits = array('banana', 'bonana'); 
	}
}
