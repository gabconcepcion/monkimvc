<?php

Loader::loadModel('Auth_Model');
$oAuth = new Auth_Model();

echo 'From Bootstrap.php:<br/>';
if(!$oAuth->hasIdentity())
	echo 'Auth Class: you are not logged in.<br/>';

if(!$oAuth->isAdmin())
	echo 'Auth Class: you are not an admin.<br/>';