<?php

class Loader
{
	
	/**
	 *	Assuming you're following ZF
	 */
	const NAMESPACE_SEPARATOR = '_';
	
	/**
	 *	Assuming you're only catering .php extension.
	 */
	const FILE_EXTENSION = '.php';
	
	function loadController($controller)
	{
		include('/applications/controllers/'.$controller.'.php');
		
		$oController = new $controller;
		return $oController;
	}
	
	function loadClass($class, $params=array())
	{
		
		if( empty( $class ) ) {
			/**
			 *	Much better if you place an exception handler here, add it on stack. Until I know
			 *	your directory structure, I'll be adding a separate exception class.
			 */
			return;
		}
		
		$className = ltrim($class, '\\');		
		$file = $namespace = '';
		if( $lastNsPos = strripos($className, '\\') ) {
		    $namespace = substr($className, 0, $lastNsPos);
		    $className = substr($className, $lastNsPos + 1);
		    $file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		
		$file = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		if( isset( $params['strict'] ) && true == $params['strict'] ) {
			require_once( '/applications/models/' . $file );
		} else {
			include('/applications/models/'.$file);
		}		
	}
	
	public static final function autoLoad( $className )
	{
		if( empty( $className ) ) {
			require_once( 'Loader' . DIRECTORY_SEPARATOR . 'Exception.php' );
			throw new Loader_Exception( 'Class cannot be loaded - no class name given.' );
		}
		
		$paths = explode( PATH_SEPARATOR, get_include_path() );		
		if( empty( $paths ) ) {
			require_once( 'Loader' . DIRECTORY_SEPARATOR . 'Exception.php' );
			throw new Loader_Exception( 'Loading aborted - how come you have an empty include path?' );
		}
		
		$baseFile = self::_toClassFile( $className ) . self::FILE_EXTENSION;
		
		foreach( $paths as $path ) {
			$targetFile = $path . DIRECTORY_SEPARATOR . $baseFile;
			if( file_exists( $targetFile ) ) {
				return require_once( $targetFile );
			}
		}
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
	
	private static function _toClassFile( $className )
	{
		if( empty( $className ) ) {
			require_once( 'Loader' . DIRECTORY_SEPARATOR . 'Exception.php' );
			throw new Loader_Exception( 'Class cannot be loaded - no class name given.' );
		}
		
		if( false !== strpos( $className, self::NAMESPACE_SEPARATOR ) ) {
			return $className;
		}
		
		return str_replace( self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, trim( $className ) );
	}
}
