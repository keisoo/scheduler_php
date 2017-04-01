<?php
	class listview extends Controller{
		function __construct(){
			parent::__construct();
			session::init();
			$this->view->js = array('listview/js/default.js');
		}
		function index(){
			$this->view->data['search'] = "";
			$this->view->data['kind'] = "";
			$this->view->data['type'] = 'notSearch';
			$this->view->render('listview/index');
		}

		function search(){
			$this->view->data['search'] = $_POST['searchField'];
			$this->view->data['type'] = 'search';
			$this->view->data['kind'] = $_POST['select'];

			// echo '<pre>';
			// var_dump($this->view->data);
			// echo '</pre>';
			// die();
			$this->view->render('listview/index');
		}

		function edit(){
			$this->model->editEvent();
			header("Location: " . URL . "listview");
		}



	}