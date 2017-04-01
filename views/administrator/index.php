<div class="container" style="margin-top: 20px;">
	<h2 class="text-center" style="margin-bottom: 50px;"><i class="fa fa-unlock"></i> ADMIN DASHBOARD</h2>
	<div class="row">
		<div class="col-md-6" style="margin-bottom: 50px;">
			<div class="panel panel-default"style="border-color: #ba2426">
				<div class="panel-heading" style="border-color: #ba2426; background-color:#ba2426">
					<h3 class="panel-title" style="color: #fff"><i class="fa fa-plus" style="color: #fff"></i> Register New Account</h3>
				</div>
				<div class="panel-body">
					<form id="register" class="text-center" method="POST" action="<?= URL?>administrator/register">
						<div class="form-group">
							<input class="form-control" type="text" placeholder="Enter Username" id = "username" name="username" required />
						</div>

						<div class="form-group">
							<input class="form-control" type="text" placeholder="Name" id = "name" name="name" required />
						</div>

						<div class="form-group">
							<input class="form-control" type="email" placeholder="Email" id = "email" name="email" required />
						</div>
					
						<div class="input-group" style="margin-bottom: 15px;">
							<input class="form-control" type="password" placeholder="Enter Password" id="password" name="password" required />
							<span class="input-group-btn">
							    <button id="unmask" class="btn btn-default" type="button">
									<span id="icon" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
							    </button>
							</span>
						</div>

						<div class="input-group">
							<input class="form-control" type="password" placeholder="Re-enter Password" id="password2" name="password2 " required />
							<span class="input-group-btn">
							    <button id="unmask2" class="btn btn-default" type="button">
									<span id="icon2" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
							    </button>
							</span>
						</div>
	 					
						<div class="form-group">
							<input id = "check_login" class="form-control btn btn-primary" type="submit" value="Register Account" name="submitButton" />
						</div>
					</form>
				</div>
			</div>
		</div>


		<div class="col-md-6">
			<div class="panel panel-default" style="border-color: #4caf50">
				<div class="panel-heading" style="border-color: #4caf50; background-color: #4caf50 ">
					<h3 class="panel-title" style="color: #fff"><i class="fa fa-clock-o" style="color: #fff"></i> Recent Activity Log</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered">
						<tr>
							<th>User</th>
							<th>Status</th>
							<th>Time</th>
						</tr>
						<?php
							foreach($this->data['activityLogs'] as $l){
								echo '<tr>
									<td>'.$l["name"].'</td>
									<td>'.($l["status"]==1?"Logged In":"Logged Out").'</td>
									<td>'.date("Y-m-d g:i a",$l["time"]).'</td>
								</tr>';
							}
						?>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default" style="border-color: #2196f3;">
				<div class="panel-heading" style="border-color: #2196f3; background-color: #2196f3 ">
					<h3 class="panel-title" style="color: #fff"><i class="fa fa-list-ul" style="color: #fff"></i> Recent Event Logs</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered
					">
						<tr>
							<th>User</th>
							<th>Title</th>
							<th>Status</th>
							<th>Time</th>
						</tr>
						<?php
							foreach($this->data['eventLogs'] as $l){
								echo '<tr>
									<td>'.$l["name"].'</td>
									<td>'.$l["title"].'</td>
									<td>'.$l["status"].'</td>
									<td>'.date("Y-m-d g:i a",$l["time"]).'</td>
								</tr>';
							}
						?>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default" style="border-color: #ffab00;">
				<div class="panel-heading" style="border-color: #ffab00; background-color: #ffab00 ">
					<h3 class="panel-title" style="color: #fff"><i class="fa fa-users" style="color: #fff"></i> List of Registered Users</h3>
				</div>
				<div class="panel-body">
					<table class="table table-hover table-bordered
					">
						<tr>
							<th>Username</th>
							<th>Name</th>
							<th>Email</th>
							<th>Status</th>
							<th>Edit/Disable Account</th>
						</tr>
						<?php

							foreach($this->data['users'] as $u){
								echo '<tr>
									<td>'.$u["username"].'</td>
									<td>'.$u["name"].'</td>
									<td>'.$u["email"].'</td>
									<td>'.($u["status"]==1?'Enabled':'Disabled').'</td>

									<td>
										<button class="btn btn-warning '.($u["status"]==1?'deleteAccount':'enableAccount').'" data-id="'.$u["id"].'">'.($u["status"]==1?'Disable':'Enable').'</button>								
										<button class="btn btn-primary editAccount" data-id="'.$u["id"].'">Edit</button>
										<button class="btn btn-success changePass" data-id="'.$u["id"].'">Change Password</button>
									</td>
								</tr>';
							}
						?>				
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Edit User Account</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      		<label> Username</label>
        	<input class="form-control" type="text" id="editUsername" />
        </div>
        <div class="form-group">
        	<label>Name</label>
      		<input class="form-control" type="text" id="editName" />  	
        </div>
        <div class="form-group">
        	<label>Email</label>
        	<input class="form-control" type="email" id="editEmail" />
        </div>
      </div>
      <input type="hidden" id="editId">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id = "editButton" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
        	<input class="form-control" type="password" id="oldPassword" placeholder="Old Password" />
        </div>
        <div class="form-group">
      		<input class="form-control" type="password" id="newPassword" placeholder="New Password" />  	
        </div>
        <div class="form-group">
        	<input class="form-control" type="password" id="newPassword2" placeholder="Confirm New Password" />
        </div>
      </div>
      <input type="hidden" id="changePassId">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id = "changePassButton" type="button" class="btn btn-primary">Change Password</button>
      </div>
    </div>
  </div>
</div>