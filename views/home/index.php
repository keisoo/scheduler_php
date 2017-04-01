	<div class="welcome text-center">
		<img src="<?=URL?>public/images/tup.png" class="animated fadeInUp">
		<h1 class="animated fadeInUp">WELCOME !</h1>
		<p class="animated fadeInUp" style="margin-bottom: 30px; font-size: 50px;">Mr./Ms. <?= session::get('name')?></p>
		<a>
			<i id="animationPulldown" style="color: #f38630" class="animated infinite slideInDown fa fa-angle-down"></i>
		</a>
	</div>

<!--Calendar-->
<div id="calendar" class="container text-center page2 calen">
	<input id="userID" type="hidden" value="<?= session::get('id')?>">
	<div class="row seven-cols">
	    <div class="col-md-1  col-xs-1 col-sm-1 col-lg-1">
	    </div>
	    <div class="col-md-1  col-xs-1 col-sm-1 col-lg-1">
	    </div>
		<div class="col-md-1  col-xs-1 col-sm-1 col-lg-1">
			<button id="prev" class="btn btn-default">&laquo; <span class="prevnextButton">Prev</span></button>
		</div>
		<div class="col-md-1  col-xs-1 col-sm-1 col-lg-1">
			<h4 id="showDate"><label id="currentYear"><?= date('Y')?></label> <label id="currentMonth"><?= date('F')?></label></h4>
		</div>
		<div class="col-md-1  col-xs-1 col-sm-1 col-lg-1">
			<button id="next" class="btn btn-default"><span class="prevnextButton">Next</span> &raquo;</button>
		</div>
	</div>
	<div class="row seven-cols" style="margin-top: 20px;">
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Sun</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Mon</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Tue</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Wed</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Thur</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Fri</strong>
		</div>
		<div class="col-md-1 col-xs-1 col-sm-1 col-lg-1">
			<strong>Sat</strong>
		</div>
	</div>
	<div id="calendarView" class="bookEvent">
	</div>
</div>


<div class="modal fade" id="noEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-md" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="dayViewLabelnoEvent"></h4>
      		</div>
      		<div class="modal-body">
      			<h1 class="text-center">NO EVENT</h1>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>
<!-- -->


<div class="modal fade" id="bookAnEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-lg" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="dayViewLabel"></h4>
      		</div>
      		<div class="modal-body">
      			<table class="table" id="dayViewModal">
      				<tr>
      					<th style="width: 200px;">Schedule</th>
      					<th>Events</th>
      				</tr>
      					<tr>
      						<td>8:00 - 9:00</td>
      						<td class="timetable" data-hour="8"></td>
      					</tr>
      					<tr>
      						<td>9:00 - 10:00</td>
      						<td class="timetable" data-hour="9"></td>
      					</tr>
      					<tr>
      						<td>10:00 - 11:00</td>
      						<td class="timetable" data-hour="10"></td>
      					</tr>
      					<tr>
      						<td>11:00 - 12:00</td>
      						<td class="timetable" data-hour="11"></td>
      					</tr>
      					<tr>
      						<td>12:00 - 1:00</td>
      						<td class="timetable" data-hour="12"></td>
      					</tr>
      					<tr>
      						<td>1:00 - 2:00</td>
      						<td class="timetable" data-hour="13"></td>
      					</tr>
      					<tr>
      						<td>2:00 - 3:00</td>
      						<td class="timetable" data-hour="14"></td>
      					</tr>
      					<tr>
      						<td>3:00 - 4:00</td>
      						<td class="timetable" data-hour="15"></td>
      					</tr>
      					<tr>
      						<td>4:00 - 5:00</td>
      						<td class="timetable" data-hour="16"></td>
      					</tr>
      			</table>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>
<!-- -->


<div class="container" style="margin-top: 20px;">

	<div class="row"><hr/>
		<h1 style="color: #e32629;">UPCOMING EVENTS</h1>
        <?php
			$i=0;
			// echo '<pre>';
			// var_dump($this->data);
			// echo '</pre>';
			// die();
			foreach ($this->data['events'] as $d) {
				if(time() < $d['start']){
					echo "<div class='preview img-responsive text-center col-md-3 col-sm-12 event-list'>";
				
					switch($d['College']){
						case 'COS':
							echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/cos.jpg' />";
						break;

						case 'CLA':
							echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/cla.gif' />";
						break;

						case 'CIT':
							echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/cit.gif' />";
						break;

						case 'CIE':
							echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/cie.gif' />";
						break;

						case 'COE':
							echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/coe.png' />";
						break;

						case 'CAFA':
								echo "<img width ='100px' height='100px' src='".URL."public/images/colleges/cafa.jpg' />";
						break;
					}
					echo "<h3>".$d['title']."</h3>";
					echo "<h4>".date('F j, Y',$d['start'])."</h4>
							<h4>".date('g:i A',$d['start'])." - ".date('g:i A',$d['end'])."</h4></div>";

				}
			}
		?>
	</div>

</div>
