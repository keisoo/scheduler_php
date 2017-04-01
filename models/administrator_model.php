<?php
	class administrator_model extends Model{
		function __construct(){
			parent::__construct();
		}

		function getActivityLogs(){
			return $this->db->select("SELECT l.*, u.name FROM `activitylog` l left join `user` u on l.user = u.id ORDER BY l.time DESC LIMIT 10");
		}

		function getEventLogs(){
			return $this->db->select("SELECT l.user,l.eventid,l.time,(CASE WHEN l.status = 0 THEN 'Added' WHEN l.status = 1 THEN 'Edited' WHEN l.status = 2 THEN 'Cancelled' END) as status, u.name, e.title FROM `eventlog` l left join `user` u on l.user = u.id left join `event` e on e.id = l.eventid ORDER BY l.id DESC LIMIT 25");
		}

		function registerAccount(){
			$data = array();
			$data['username'] = $_POST['username'];
			$data['password'] = hash::create('md5',$_POST['password'],HASH_PASSWORD_KEY);
			$data['name'] = $_POST['name'];
			$data['email'] = $_POST['email'];
			$this->db->insert('user',$data);
		}

		function getUsers(){
			return $this->db->select("SELECT * FROM `user`");
		}

	}
