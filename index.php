<?php
set_time_limit(0);

$_protocol = $_SERVER['HTTPS'] ? "https" : "http";
$_base_url = $_protocol . "://" . $_SERVER['HTTP_HOST'];
define('BASE_URL', $_base_url.'/monkimvc/');

define('APPLICATION_PATH', './applications/');
// use ../library, if library dir is located outside this framework
define('LIBRARY_PATH', './library/');

$sConfigFile = 'default';
if($_SERVER['SERVER_ADDR']=='127.0.0.1')
{
	/*PHP error settings*/
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors','On'); 
	
	$sConfigFile = 'development';
}
//load config
$aConfig = parse_ini_file(APPLICATION_PATH."{$sConfigFile}.ini", true);

set_include_path(implode(PATH_SEPARATOR,array(
	'.',         
	LIBRARY_PATH, 
	'./applications/controllers',
	'./applications/models',
	get_include_path()
)));
require_once('Monki/Loader.php');

//sanitize controller/action request
$_GET['controller'] = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['controller']);
$_GET['action'] = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['action']);
	
//load controller
$controller = $_GET['controller'];
$action = $_GET['action'];

if(!$controller)
	$controller = 'home';
if(!$action)
	$action = 'index';

$oLoader = new Monki_Loader();
$oLoader->loadClass('Monki_View');
$oLoader->loadClass('Monki_Model');
$oLoader->loadClass('Monki_Controller');

//database settings
$oDb = null;
$aDbConfig = $aConfig['db'];
if($aDbConfig['type']==='mysql')
{
    $aParams = array(
        'host'=>$aDbConfig['host'],
        'user'=>$aDbConfig['user'],
        'password'=>$aDbConfig['password'],
        'dbname'=>$aDbConfig['dbname'],
    );
    $oLoader->loadClass('Monki_Db_MySQL_Handler');
    $oDb = new Monki_Db_MySQL_Handler($aParams);
}
elseif($aDbConfig['type']==='sqlite')
{
    $oLoader->loadClass('Monki_Db_SQLite_Handler');
    $oDb = new Monki_Db_SQLite_Handler($aDbConfig['sqlite_file']);
}

//database connection
$oLoader->loadClass($controller);
$oController = new $controller($oDb);

//constants
$oLoader->loadClass('Constants');

//call Bootstrap
include('applications/Bootstrap.php');

//call action
$oController->$action();

//set variables for view
$aVars = get_object_vars($oController->view);
foreach($aVars as $key=>$val)
{
	$$key = $val;
}

//output the view
ob_start();

if(!$oController->noRender)
	include("/applications/views/{$controller}/$action.php");

$content = ob_get_clean();
echo $content;