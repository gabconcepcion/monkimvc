<?php

class Test extends Monki_Controller
{
        function index()
        {
                $this->setNoRender();
                $a = get_class_methods($this);
                
                echo '<b>Test</b><br/>';
                foreach($a as $m)
                {
                        if($m == '__construct' || $m == 'index' || $m == 'setNoRender') continue;
                                echo '<a href="'.BASE_URL.'test/'.$m.'">/monkimvc/test/'.$m.'</a><br/>';
                }
        }
        
        function zend()
        {                
                //monkimvc/../library/Zend
		require_once(APPLICATION_PATH.'../../library/Zend/Loader.php');      
                
		Zend_Loader::loadClass('Zend_Json');
		
        	$data = array('text'=>'Hello World');   
		$this->view->json = Zend_Json::encode($data);
		
		Zend_Loader::loadClass('Zend_Locale');
		$oMyLocale = new Zend_Locale(Zend_Locale::BROWSER);
		
		$this->view->myLocale = $oMyLocale->toString();
        }
        
        function mysql()
        {
                $this->setNoRender();
                
                $aParams = array(
                        'host'=>'localhost',
                        'user'=>'root',
                        'password'=>'',
                        'dbname'=>'monkimvc',
                );
                Monki_Loader::loadClass('Monki_Db_MySQL_Handler');
                $oDb = new Monki_Db_MySQL_Handler($aParams);
                
                $sSql = 'SELECT * FROM posts WHERE 1';
                $aPosts = $oDb->fetchAll($sSql);
                var_export($aPosts);
        }
	
	function hybridAuth()
	{
		//ref: http://hybridauth.sourceforge.net/
		
		$this->setNoRender();
		
                //monkimvc/../library/hybridauth
        	require_once(APPLICATION_PATH.'../../library/hybridauth/hybridauth.php');
		$oHybridAuth = new Hybrid_Auth();
		
		if( $oHybridAuth->hasError() )
		{
			echo $oHybridAuth->getErrorMessage();
		}
	
		// if user already connected, redirect to profile page
		if( $oHybridAuth->hasSession() )
		{
			//$oHybridAuth->redirect( "profile.php" );
			$aUserdata = $provider_adapter->user()->profile;
			echo 'Profile:';
			var_export($aUserdata);
		}
	
		// if a provider has been selected
		if( isset( $_GET["provider"] )  )
		{
			$params = array(); 

			// URL of your application which will be called after authentication 
			$params["hauth_return_to"]      = $oHybridAuth->getCurrentUrl() ; // after authentication, return to this same page
	
			$provider                       = @$_REQUEST["provider"];       // selected provider name 
	
			// setup a new connection// setup a new connection
			$provider_adapter = $oHybridAuth->setup( $provider, $params );
	
			// catch if setup error
			if( ! $provider_adapter )
			{
				echo $oHybridAuth->getErrorMessage();
			}
	
			// start login
			$login_is_ok = $provider_adapter->login();
	
			// catch if login error
			if( ! $login_is_ok )
			{
				echo $oHybridAuth->getErrorMessage();
			}
		}
		else
		{
			echo '
				&nbsp;&nbsp;<a href="?provider=Google&google_service=Users">Sign-in with Google</a>  (Gmail, Orkut, Youtube, etc.)<br /> 
				&nbsp;&nbsp;<a href="?provider=Facebook">Sign-in with Facebook</a><br />
				&nbsp;&nbsp;<a href="?provider=MySpace">Sign-in with MySpace</a><br />
				&nbsp;&nbsp;<a href="?provider=Twitter">Sign-in with Twitter</a><br />
				&nbsp;&nbsp;<a href="?provider=Live">Sign-in with Windows Live</a><br />
				&nbsp;&nbsp;<a href="?provider=Tumblr">Sign-in with Tumblr</a><br />
				&nbsp;&nbsp;<a href="?provider=Foursquare">Sign-in with Foursquare</a><br />
				&nbsp;&nbsp;<a href="?provider=LinkedIn">Sign-in with LinkedIn</a><br />
				&nbsp;&nbsp;<a href="?provider=Vimeo">Sign-in with Vimeo</a><br />
				&nbsp;&nbsp;<a href="?provider=Gowalla">Sign-in with Gowalla</a><br />
				&nbsp;&nbsp;<a href="?provider=Friendster">Sign-in with Friendster</a><br />
				&nbsp;&nbsp;<a href="?provider=PayPal">Sign-in with PayPal</a><br />
				&nbsp;&nbsp;<a href="?provider=Yahoo">Sign-in with Yahoo</a><br /> 
			';
		}
	}
	
	function sqlite()
	{
		$this->setNoRender();
		
		$file = APPLICATION_PATH.'sql/db.sqlite';
		
		Monki_Loader::loadClass('Monki_Db_SQLite_Handler');
		$oSQLite = new Monki_Db_SQLite_Handler($file);
		
		$aResult = $oSQLite->fetchRow("SELECT * FROM posts");
		var_export($aResult);
	}
}