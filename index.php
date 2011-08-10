<?php
$controller = $_GET['controller'];
$action = $_GET['action'];

if(!$controller)
	$controller = 'home';
if(!$action)
	$action = 'index';

include('system/Loader.php');
include('system/Controller.php');
include('system/Model.php');
include('system/View.php');

$oLoader = new Loader();

if($_SERVER['SERVER_ADDR']=='127.0.0.1')
{
	/*PHP error settings*/
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors','On'); 
	
	$sConfig = 'development';
}
else
{
	
}

//load config
$aConfig = parse_ini_file("applications/{$sConfig}.ini", true);

//constants
$oLoader->loadClass('Constants');

//call Bootstrap
include('applications/Bootstrap.php');


$oController = $oLoader->loadController($controller);

//call action
$oController->$action();

$oLoader->renderView($oController, $action);
