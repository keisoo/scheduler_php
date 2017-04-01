<?php
	class login extends Controller{
		function __construct(){
			parent::__construct();
			session::init();
			$this->view->js = array('login/js/default.js');
		}
		function index(){
			session::destroy();
			$this->view->render('login/index', true);
		}

		function logout(){
			$this->model->logoutLogs();
			session::destroy();
			header('Location: ' . URL);
		}


	}