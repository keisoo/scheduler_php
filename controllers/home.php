<?php
	class home extends Controller{
		function __construct(){
			parent::__construct();
			session::init();
			$this->view->js = array('home/js/default.js');
		}
		function index(){
			$this->view->data['events'] = $this->model->getEvent();
			$this->view->render('home/index');
		}

		function add(){
			$page = $_POST['currentPage'];
			$this->model->add();
			header("Location: " . URLtrimmed . $page);
		}

		function retrieve(){
			$this->model->retrieve();
		}

		function edit(){
			$this->model->edit();
			header("Location: " . URL . 'listview');
		}


	}