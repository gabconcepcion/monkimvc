<?php

class Request extends Controller
{
    function isPost()
    {
        return (empty($_POST));    
    }
    
    function isGet()
    {
        return (empty($_GET));    
    }
    
    function hasFiles()
    {
        return (empty($_FILES));    
    }    
    
    function getGet($key=null)
    {
        if(!is_null($key)) 
            return $_GET[$key];
        
        return $_GET;
    }    
    
    function getPost($key=null)
    {
        if(!is_null($key)) 
            return $_POST[$key];
        
        return $_POST;
    }  
    
    function getFile($key=null)
    {
        if(!is_null($key)) 
            return $_FILES[$key];
        
        return $_FILES;
    }
    
}