<?php
	class administrator extends Controller{
		function __construct(){
			parent::__construct();
			session::init();
			$this->view->js = array('administrator/js/default.js');
		}
		function index(){
			if(session::get('type') == 1){
				$this->view->data['activityLogs'] = $this->model->getActivityLogs();
				$this->view->data['eventLogs'] = $this->model->getEventLogs();
				$this->view->data['users'] = $this->model->getUsers();
				// echo "<pre>";
				// var_dump($this->view->data);
				// echo "</pre>";
				// die();
				$this->view->render('administrator/index');
			}else{
				header('Location: '.URL);
			}
		}

		function register(){
			$this->model->registerAccount();
			header("Location: ".URL."administrator");
		}


	}