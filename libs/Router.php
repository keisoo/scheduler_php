<?php

class Router {

	function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;	//
		$url = rtrim($url, '/');							//trim those slash slash slash hahaha
		$url = filter_var($url, FILTER_SANITIZE_URL);		//	
		$url = explode('/', $url);							//turn string into series of url/url/url/
        session::init();									//initialize session. look at libs/session.php
		// print_r($url);
		
        //Database::query("UPDATE 'event' SET");


		if (empty($url[0])) {								//check account
			if(session::get('id')!=null){
				require 'controllers/home.php';
				$controller = new home();
	            $controller->loadModel('home');
	            $controller->index();
	            return false;
			}else{
	            require 'controllers/login.php';
	            $controller = new login();
	            $controller->loadModel('login');
	            $controller->index();
	            return false;
        	}
        }
        
        foreach($url as $u){
        	if($u == 'ajax'){
        		require 'controllers/ajax.php';
				$controller = new ajax();
				$controller->loadModel('ajax');
				$controller->run();
				return false;
        	}
        }

		$file = 'controllers/' . $url[0] . '.php';

		if (file_exists($file)) {
			if(empty(session::get('id'))){
				require 'controllers/login.php';
		           $controller = new login();
		           $controller->loadModel('login');
		           $controller->index();
		           return false;
			}
            require $file;   
		} 
		else {
			$this->error();
		}
        
		$controller = new $url[0];
		$controller->loadModel($url[0]);
        
		// calling methods
		if (isset($url[2])) {
			if (method_exists($controller, $url[1])) {
				$controller->{$url[1]}($url[2]);
			} 
			else {
				$this->error();
			}
		} 
		else {
			if (isset($url[1])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}();
				} 
				else {
					$this->error();
				}
			} 
			else {
				$controller->index();
			}
		}
		
	}
	
	function error() {
		header('Location: ' . URL);
	}

}

?>