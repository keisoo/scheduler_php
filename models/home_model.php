<?php
	class home_model extends Model{
		function __construct(){
			parent::__construct();
		}

		function add(){

			$data = array();
			$data['title'] = $_POST['title'];
			$data['start'] = strtotime($_POST['startDate'] . ' ' . $_POST['startTime']);
			$data['end'] = strtotime($_POST['startDate'] . ' ' . $_POST['endTime']);
			$data['organizer'] = $_POST['organizer'];
			$data['College'] = $_POST['College'];
			$data['user'] = session::get('id');
			$this->db->insert('event',$data);

		}
		
		function getEvent(){
			return $this->db->select("SELECT * from `event` order by `start`");
		}

	}
