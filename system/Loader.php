<?php

class Loader
{
	function loadController($controller)
	{
		include('/applications/controllers/'.$controller.'.php');
		
		$oController = new $controller;
		return $oController;
	}
	
	function loadClass($class, $params=array())
	{
		$className = ltrim($class, '\\');
		$file      = '';
		$namespace = '';
		if ($lastNsPos = strripos($className, '\\')) {
		    $namespace = substr($className, 0, $lastNsPos);
		    $className = substr($className, $lastNsPos + 1);
		    $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$file = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		include('/applications/models/'.$file);
	}
	
	function loadModel($model, $params=array())
	{
		/** loadClass() copy - Need to use this for now to prevent error when calling as Loader::loadModel()*/
		$class = $model;
		$className = ltrim($class, '\\');
		$file      = '';
		$namespace = '';
		if ($lastNsPos = strripos($className, '\\')) {
		    $namespace = substr($className, 0, $lastNsPos);
		    $className = substr($className, $lastNsPos + 1);
		    $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$file = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		include('/applications/models/'.$file);
		/** END loadClass() copy*/
		
		$oModel = new $model($params);
		return $oModel;
	}
	
	function renderView(Controller $oController, $action)
	{
		$aVars = get_object_vars($oController->view);
		
		foreach($aVars as $key=>$val)
		{
			$$key = $val;
		}
		
		$controller = get_class($oController);
		include("/applications/views/{$controller}/$action.php");
	}
}
