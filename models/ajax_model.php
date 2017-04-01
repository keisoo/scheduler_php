<?php
	class ajax_model extends Model{
		function __construct(){
			parent::__construct();
		}
		function run(){
			$args = (isset($_POST['args'])?$_POST['args']:null);
			$data = array();
			switch($_POST['type']){
				case 'login':
					$data[':user'] = $args['user'];
					$data[':pass'] = hash::create('md5',$args['pass'],HASH_PASSWORD_KEY); //password encryption
					$result = $this->db->select("SELECT * FROM user WHERE username = :user AND password = :pass AND status = 1",$data);
            		if($result){
                		session::init();
                		session::set('loggedIn',true);
                		session::set('name', $result[0]['name']);
                		session::set('id', $result[0]['id']);
                		session::set('type', $result[0]['type']);
                		$data2['user'] = session::get('id');
                		$data2['time'] = strtotime(date('Y-m-d H:i:s'));
                		$data2['status'] = 1;
                		$this->db->insert('activitylog',$data2);
                		echo 1;
            		}
            		else{
                		echo 0;
            		}
				break;

				case 'accountValidation':
					$data[':user'] = $args['user'];
					$data[':email'] = $args['email'];
					$rs = $this->db->select("SELECT * FROM `user` WHERE `username` = :user OR `email` = :email",$data);
					if(empty($rs)){
						echo 1;
					}else{
						echo 0;
					}
				break;

				case 'deleteAccount':
					$id = $args['id'];
					$data['status'] = 0;
					$this->db->update('user',$data,"`id` = $id");
				break;

				case 'enableAccount':
					$id = $args['id'];
					$data['status'] = 1;
					$this->db->update('user',$data,"`id` = $id");
				break;

				case 'events':
					$page = $args['page']*10;
					$type = $args['type2'];
					if($type == 'notSearch'){
						$rs = $this->db->select("SELECT e.id, e.title, e.start, e.end, e.organizer, e.College, (CASE WHEN `cancelled` = 1 THEN 'Cancelled' WHEN UNIX_TIMESTAMP() > e.start THEN 'Finished' WHEN UNIX_TIMESTAMP() BETWEEN e.`start` and e.`end` THEN 'Ongoing' ELSE 'Upcoming' END) as `status`, u.name name, (SELECT count(*) FROM `event`) num FROM `event` e left join `user` u on e.user = u.id ORDER BY e.`start` LIMIT $page,10");
						if(empty($rs)){
							$result['output'] = "No Events Yet!";
							$result['num'] = 0;
							echo json_encode($result);
						}else{
							ob_start();

							echo '<table class="table table-hover table-striped table-bordered">
									<tr>
										<th>Status</th>
										<th>Title</th>
										<th>Start Date/Time</th>
										<th>End Time</th>
										<th>Organizer</th>
										<th>College</th>
										<th>Uploader</th>
										<th>Edit / Cancel</th>
									</tr>
							';

							foreach($rs as $r){
								echo '
									<tr>
										<td>'.$r["status"].'</td>
										<td>'.$r["title"].'</td>
										<td>'.date('Y F j g:i A', $r["start"]).'</td>
										<td>'.date('g:i A', $r["end"]).'</td>
										<td>'.$r["organizer"].'</td>
										<td>'.$r["College"].'</td>
										<td>'.$r["name"].'</td>
										<td><button data-toggle="modal" data-target="#myModal2" data-id="'.$r["id"].'" class="btn btn-warning editEventButton" '.($r["status"]=="Upcoming"?"":"disabled").'>Edit</button> <button data-id="'.$r["id"].'" class="eventDelete btn btn-danger" '.($r["status"]=="Upcoming"?"":"disabled").'>Cancel</button></td>
									</tr>
								';
							}
							echo '</table>';

							$output = ob_get_contents();
							ob_end_clean();
							$result['output'] = $output;
							$result['num'] = $rs[0]['num'];
							echo json_encode($result);
						}
					}else{
						$data[':search'] = $args['search'];
						$kind = $args['kind'];

						$rs = $this->db->searching("SELECT e.id, e.title, e.start, e.end, e.organizer, e.College, (CASE WHEN `cancelled` = 1 THEN 'Cancelled' WHEN UNIX_TIMESTAMP() > e.start THEN 'Finished' WHEN UNIX_TIMESTAMP() BETWEEN e.`start` and e.`end` THEN 'Ongoing' ELSE 'Upcoming' END) as `status`, u.name name, (SELECT count(*) FROM `event` WHERE $kind LIKE :search) num FROM `event` e left join `user` u on e.user = u.id WHERE $kind LIKE :search ORDER BY e.`start` LIMIT $page,10",$data);
						if(empty($rs)){
							$result['output'] = "Did not match any events";
							$result['num'] = 0;
							echo json_encode($result);
						}else{
							ob_start();

							echo '<table class="table table-hover table-striped table-bordered">
									<tr>
										<th>Status</th>
										<th>Title</th>
										<th>Start Date/Time</th>
										<th>End Date/Time</th>
										<th>Organizer</th>
										<th>College</th>
										<th>Uploader</th>
										<th>Edit / Cancel</th>
									</tr>
							';

							foreach($rs as $r){
								echo '
									<tr>
										<td>'.$r["status"].'</td>
										<td>'.$r["title"].'</td>
										<td>'.date('Y F j g:i A', $r["start"]).'</td>
										<td>'.date('Y F j g:i A', $r["end"]).'</td>
										<td>'.$r["organizer"].'</td>
										<td>'.$r["College"].'</td>
										<td>'.$r["name"].'</td>
										<td><button data-toggle="modal" data-target="#myModal2" data-id="'.$r["id"].'" class="btn btn-warning editEventButton" '.($r["status"]=="Upcoming"?"":"disabled").'>Edit</button> <button data-id="'.$r["id"].'" class="eventDelete btn btn-danger" '.($r["status"]=="Upcoming"?"":"disabled").'>Cancel</button></td>
									</tr>
								';
							}
							echo '</table>';

							$output = ob_get_contents();
							ob_end_clean();
							$result['output'] = $output;
							$result['num'] = $rs[0]['num'];
							echo json_encode($result);
						}
					}
					
				break;

				case 'deleteEvent':
					$id = $args['id'];
					$data['cancelled'] = 1;
					$this->db->update('event',$data,"`id` = $id");
					$data2['user'] = session::get('id');
					$data2['time'] = strtotime(date('Y-m-d H:i:s'));
					$data2['status'] = 2;
					$data2['eventid'] = $id;
					$this->db->insert('eventlog',$data2);
				break;

				case 'retrieveEditEvent':
					$id = $args['id'];
					$rs = $this->db->select("SELECT * from `event` WHERE `id` = $id LIMIT 1");
					$data['title'] = $rs[0]['title'];
					$data['startDate'] = date('Y-m-d' , $rs[0]['start']);
					$data['startTime'] = date('H:i' , $rs[0]['start']);
					$data['endTime'] = date('H:i' , $rs[0]['end']);
					$data['organizer'] = $rs[0]['organizer'];
					$data['college'] = $rs[0]['College'];
					
					echo json_encode($data);
				break;

				case 'dayView':
					$data[':eventDateStart'] = strtotime($args['d'] . '-' . $args['m'] . '-' . $args['y']);
					$data[':eventDateEnd'] = $data[':eventDateStart'] + 86400;
 					$rs = $this->db->select("SELECT `title`, `start`, `end` FROM `event` WHERE `start` >= :eventDateStart AND `start` < :eventDateEnd AND `cancelled` != 1",$data);
 					// echo json_encode($rs);
 					if(!empty($rs)){
 						foreach($rs as $r){
 							static $i = 0;
 							$rs[$i]['hourStart'] = date('G' , $r['start']);
 							$rs[$i]['hourEnd'] = date('G', $r['end']);
 							$i++;
 						}
 						echo json_encode($rs);
 					}else{
 						echo false;
 					}
				break;

				case 'getEvents':
					$rs = $this->db->select("SELECT * FROM `event` WHERE `cancelled` != 1");
					if(empty($rs)){
						echo 0;
					}else{
						foreach($rs as $r){
							static $i = 0;
							$rs[$i]['month'] = date('n',$r['start']);
							$rs[$i]['day'] = date('j',$r['start']);
							$rs[$i]['year'] = date('Y',$r['start']);
							$i++;
						}
						echo json_encode($rs);
					}
				break;

				case 'checkEvent':
					$data[':eventDateStart'] = strtotime($args['startDate'] . ' ' . $args['startTime']);
					$data[':eventDateEnd'] = strtotime($args['startDate'] . ' ' . $args['endTime']);

					if($data[':eventDateStart'] < strtotime(date('Y-m-d H:i:s')) || $data[':eventDateEnd'] < strtotime(date('Y-m-d H:i:s'))){

						echo 2; //invalid start date coz inputed day is before current date

					}else if($data[':eventDateStart'] > $data[':eventDateEnd']){
						echo 3; //end date is earlier than start date
					}else{
						$rs = $this->db->select("SELECT * FROM `event` WHERE (`start` < :eventDateStart AND `end` > :eventDateStart) OR (`start` < :eventDateEnd AND `end` > :eventDateEnd) OR (`start` = :eventDateStart AND `end` = :eventDateEnd) AND `cancelled` != 1",$data);

						if(!empty($rs)){
							echo 1;
						}else{
							echo 0;
						}
					}

					

				break;

				case 'addEvent':
					$data['start'] = strtotime($args['startDate'] . ' ' . $args['startTime']);
					$data['end'] = strtotime($args['startDate'] . ' ' . $args['endTime']);
					$data['title'] = $args['title'];
					$data['organizer'] = $args['organizer'];
					$data['College'] = $args['college'];
					$data['user'] = session::get('id');
					$this->db->insert('event',$data);

					$id = $this->db->select("SELECT `id` from `event` ORDER BY `id` DESC LIMIT 1");
					$data2['user'] = session::get('id');
					$data2['time'] = strtotime(date('Y-m-d H:i:s'));
					$data2['status'] = 0;
					$data2['eventid'] = $id[0]['id'];
					$this->db->insert('eventlog',$data2);


				break;

				case 'getSingleUser':
					$id = $args['id'];
					$rs = $this->db->select("SELECT * FROM `user` WHERE `id` = $id");
					echo json_encode($rs);
				break;

				case 'changeUserAccount':
					$id = $args['id'];
					$data['username'] = $args['username'];
					$data['name'] = $args['name'];
					$data['email'] = $args['email'];
					$this->db->update('user' , $data, "`id` = $id");
 				break;

 				case 'changePassword':
 					$id = $args['id'];
 					$data[':password'] = hash::create('md5', $args['oldPass'], HASH_PASSWORD_KEY);
 					$pass1 = $args['oldPass'];
 					$pass2 = $args['newPass'];
 					$pass3 = $args['newPass2'];

 					$rs = $this->db->select("SELECT * FROM `user` WHERE `password` = :password", $data);

 					if(empty($rs)){
 						echo 0; //wrong old password
 					}else{
 						if($pass2 == $pass3){
 							$data2['password'] = hash::create('md5', $args['newPass'], HASH_PASSWORD_KEY);
 							$this->db->update('user', $data2, "`id` = $id");
 							echo 2; //accepted
 						}else{
 							echo 1; //password does not match
 						}
 					}


 				break;
			}
		}
	}