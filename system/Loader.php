<?php

class Loader
{
	function loadController($controller)
	{
		include('/applications/controllers/'.$controller.'.php');
		
		$oController = new $controller;
		return $oController;
	}
	
        // From ZF  
        // Autodiscover the path from the class name
        // Implementation is PHP namespace-aware, and based on
        // Framework Interop Group reference implementation:
        // http://groups.google.com/group/php-standards/web/psr-0-final-proposal
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
		
		return array('namespace'=>$namespace,'className'=>$className,'file'=>$file,);
	}
	
	static function loadModel($model, $params=array())
	{
		$oThis = new self();
		$aClassInfo = $oThis->loadClass($model, $params);
		
		$model = $aClassInfo['className'];
		$oModel = new $model($params);
		return $oModel;
	}
}