<?php

class Auth_Model extends Monki_Model
{
	function hasIdentity()
	{
		return false;
	}
	
	function isAdmin()
	{
		return ($this->type == Constants::USERGROUP_ADMIN);
	}
}
