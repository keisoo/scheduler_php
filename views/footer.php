<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="myModalLabel">Add an Event</h4>
      		</div>
      		<div class="modal-body">
        		<form id="addEvent" method="POST" action="#">
        			<div class="form-group">
        				<label>Event Title</label>
        				<input name="title" id="eventTitle" class="form-control" type="text" placeholder="ex. COS Week" required />
        			</div>
        			<div class="form-group">
        				<label>Event Date</label>
        				<input class="form-control" type="date" name="startDate" id="startDate" value="<?= date('Y-m-d');?>" required/>
        			</div>
        			<div class="form-group">
        				<label>Event Start Time</label>
        				<input class="form-control" type="time" name="startTime" id="startTime" min="08:00:00" max="17:00:00" required/>
        			</div>
        			<div class="form-group">
        				<label>Event End Time</label>
        				<input class="form-control" type="time" name="endTime" id="endTime" min="08:00:00" max="17:00:00" required/>
        			</div>
        			<div class="form-group">
        				<label>Event Organizer</label>
        				<input class="form-control" type="text" placeholder="ex. COS Dean" name="organizer" id="organizer" required/>
        			</div>
        			<div class="form-group">
        				<label>College</label>
                        <select class="form-control" name="College" id="College" >
                            <option value="">--</option>
                            <option value="COE">College of Engineering</option>
                            <option value="CAFA">College of Architecture and Fine Arts</option>
                            <option value="CIE">College of Industrial Education</option>
                            <option value="CIT">College of Industrial Technology</option>
                            <option value="CLA">College of Liberal Arts</option>
                            <option value="COS">College of Science</option>
                        </select>
        			</div>
                    <input type="hidden" name="currentPage" value="<?= $_SERVER['REQUEST_URI']?>" />


      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		
                <input id="addEventHeader" type="submit" value="Add Event" class="btn btn-danger" />
                </form>
      		</div>
    	</div>
  	</div>
</div>

<div class="footer-nav">
	<div class="container-fluid">
	    <p class="navbar-text pull-left" style="margin-top:10px;">Technological University of the Philippines</p>
        <p class="navbar-text copy pull-right" style="margin-bottom:10px;"> &copy 2016	</p>
	</div>
</div>	

</body>
<script type="text/javascript" src="<?= URL?>public/js/script.js"></script>
<script src="<?= URL?>public/bootstrap/js/bootstrap.min.js"></script>
</html>