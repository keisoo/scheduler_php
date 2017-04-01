<?php
  session::init();
?>
<!DOCTYPE html>
<html>
<head>
    <title>IRTC</title>
    <link rel="stylesheet" href="<?= URL?>public/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= URL?>public/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= URL?>public/css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= URL?>public/js/jquery.js"></script>
    <?php 
        if(isset($this->js)){ 
            foreach($this->js as $js){
                echo '<script src = "' . URL . 'views/' . $js . '"></script>';
            }
        }
    ?>
</head>
<body>
	<div class="container" style="margin-top: 20px;">
		<div class="row">
			<img class="center-block" src="<?= URL?>public/images/tup.png" style="width: 250px;"/>
			<h3 class="text-center">Integrated Research and Training Center</h3>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3" style="">
				<div id = "wrongAccount" class="alert alert-danger text-center" role="alert">Wrong Username or Password!</div>
				<form id="login" class="text-center" method="POST" action="">
					<div class="form-group">
						<input class="form-control" type="text" placeholder="Enter Username" id = "username" name="username" />
					</div>
				
					<div class="input-group">
						<input class="form-control" type="password" placeholder="Enter Password" id="password" name="password" />
						<span class="input-group-btn">
						    <button id="unmask" class="btn btn-default" type="button">
								<span id="icon" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
						    </button>
						</span>
					</div>
 					
					<div class="form-group">
						<input id = "check_login" class="form-control btn btn-primary" type="submit" value="Login" name="submitButton" />
					</div>
				</form>
			</div>
		</div>
	</div>
	
</body>
<script src="<?= URL?>public/bootstrap/js/bootstrap.min.js"></script>
</html>
