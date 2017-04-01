<?php
	class listview_model extends Model{
		function __construct(){
			parent::__construct();
		}

		function editEvent(){
			$data = array();

			$id = $_POST['id'];
			$data['title'] = $_POST['title'];
			$data['start'] = strtotime($_POST['date'] . ' ' . $_POST['startTime']);
			$data['end'] = strtotime($_POST['date'] . ' ' . $_POST['endTime']);
			$data['organizer'] = $_POST['organizer'];
			$data['College'] = $_POST['college'];

			$this->db->update('event',$data,"`id`=$id");

			$data2['user'] = session::get('id');
			$data2['time'] = strtotime(date('Y-m-d H:i:s'));
			$data2['status'] = 1;
			$data2['eventid'] = $id;
			$this->db->insert('eventlog',$data2);
		}

	}
