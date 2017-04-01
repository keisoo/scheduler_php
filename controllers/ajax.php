<?php
	class ajax extends Controller{
		function __construct(){
			parent::__construct(false);
		}
		function run(){
			$this->model->run();
		}

	}