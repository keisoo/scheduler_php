
<div class="container-fluid" id = "checkType" data-type = "<?= $this->data['type']?>" data-search="<?= $this->data['search']?>" data-kind = "<?= $this->data['kind'] ?>">
	<h3 class="text-center">View All Events</h3>
	<div id="eventList">
		
	</div>
</div>
<div id="pagination">
</div>
<div class="modal fade" id="editAnEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="">Edit this Event</h4>
      		</div>
      		<div class="modal-body">
      			<form method="POST" action="<?= URL?>listview/edit">
      				<div class="form-group">
      					<label>Event Title</label>
      					<input name="title" id="editEventTitle" class="form-control" type="text" required />
      				</div>	
      				<div class="form-group">
      					<label>Event Date</label>
      					<input name="date" id="editEventDate" class="form-control" type="date" required />
      				</div>
      				<div class="form-group">
      					<label>Event Start</label>
      					<input name="startTime" id="editEventStart" class="form-control" type="time" min="08:00:00" max="17:00:00" required />
      				</div>
      				<div class="form-group">
      					<label>Event End</label>
      					<input name="endTime" id="editEventEnd" class="form-control" type="time" min="08:00:00" max="17:00:00" required />
      				</div>
      				<div class="form-group">
      					<label>Event Organizer</label>
      					<input name="organizer" id="editEventOrganizer" class="form-control" type="text" required />
      				</div>
      				<label>College</label>
      				<select name="college" class="form-control" id="editEventCollege">
      					<option>--</option>
                        <option value="COE">College of Engineering</option>
                        <option value="CAFA">College of Architecture and Fine Arts</option>
                        <option value="CIE">College of Industrial Education</option>
                        <option value="CIT">College of Industrial Technology</option>
                        <option value="CLA">College of Liberal Arts</option>
                        <option value="COS">College of Science</option>
      				</select>
      			
      		</div>
      		<div class="modal-footer">
      			<input name="id" type="hidden" id="editEventId">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input class="btn btn-primary" type="submit" value="Edit Event"></input>
        		</form>
      		</div>
    	</div>
  	</div>
</div>

