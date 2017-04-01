<?php
	class login_model extends Model{
		function __construct(){
			parent::__construct();
		}

		function logoutLogs(){
			$data2['user'] = session::get('id');
            $data2['time'] = strtotime(date('Y-m-d H:i'));
            $data2['status'] = 0;
            $this->db->insert('activitylog',$data2);
		}	

	}
