jQuery(document).ready(function($){
// objects
	var months = {
		1 : 'January',
		2 : 'February',
		3 : 'March',
		4 : 'April',
		5 : 'May',
		6 : 'June',
		7 : 'July',
		8 : 'August',
		9 : 'September',
		10 : 'October',
		11 : 'November',
		12 : 'December'
	};

	var colors = {
		1: '#faadad',
		2: '#facfad',
		3: '#f9faad',
		4: '#b7faad',
		5: '#adfaf7',
		6: '#adb6fa',
		7: '#f7adfa',
		8: '#8f8f8f',
		9: '#ffc955'
	}

//scripts
	var week;
	var day;
	var month = new Date($("#currentMonth").html() + '-1-01').getMonth()+1;
	var year = $("#currentYear").html();
	var eventID = 0;
	var id = $('#userID').val();
	var numRow = 0;

	initialization(month,year);

	$('#prev').click(function(){
		if(month == 1){
			year--;
			$('#currentYear').html(year);
			month = 12;
		}else{
			month = new Date($("#currentMonth").html() + '-1-01').getMonth()+1-1;
		}
		$('#currentMonth').html(months[month]);
		$('#calendarView').html('');
		initialization(month,year);
	});

	$('#next').click(function(){
		if(month == 12){
			year++;
			$('#currentYear').html(year);
			month = 1;
		}else{
			month = new Date($("#currentMonth").html() + '-1-01').getMonth()+1+1;
		}
		$('#currentMonth').html(months[month]);
		initialization(month,year);
	});

	$('#calendarView').delegate("button.btn.btn-primary","click",function(){
		$('.timetable').html('').css('background-color','white');
		var m = $(this).attr('data-month');
		var d = $(this).attr('data-day');	
		var y = $(this).attr('data-year');
		var time =  8;
		$('#dayViewLabel').html("Events on " + months[m] + " " + d + ", " + y);
		$('#eventMonth').val(m);
		$('#eventDay').val(d);
		$('#eventYear').val(y);
		$.post('ajax' , { type :  'dayView' , args : { m : m , d : d , y : y} } , function(response){
			// alert(response);
			var colorNum = 1;
			$.each(response,function(e){
				var hours = parseInt(response[e]['hourEnd']) - parseInt(response[e]['hourStart']);
				var starthour = response[e]['hourStart'];
				for(var i = 0; i < hours; i++){
					$("table#dayViewModal tr td[data-hour='"+starthour+"']").html('').css('background-color',colors[colorNum]).append(response[e]['title']);
					starthour++;
				}
				colorNum++;
			});
		},'JSON');
		$('#bookAnEvent').modal('show');
	});

	$('#calendarView').delegate("button.btn.btn-default","click",function(){
//	$('table#dayViewModal tr td.timetable').html('No Events on this date.').css('background-color','white');
	var m = $(this).attr('data-month');
		var d = $(this).attr('data-day');	
		var y = $(this).attr('data-year');
		$('#dayViewLabelnoEvent').html("Events on " + months[m] + " " + d + ", " + y);
		$('#noEvent').modal('show');
	});

	$('#eventSubmit').click(function(e){
		e.preventDefault();
		var title = $('#bookEventTitle').val();
		var m = $('#eventMonth').val();
		var d = $('#eventDay').val();
		var y = $('#eventYear').val();
		$.post('ajax' , { type : 'bookEvent' , args : { title : title , m : m , d : d , y : y } } , function(response){
			if(response == 1){
				alert("Reservation Completed");
				initialization(month,year);
			}else{
				alert("Sorry, we're fully  booked on that day.");
			}
		});
	});

	//script for editing an event
	$('#editEventSubmit').click(function(e){
		e.preventDefault();
		var title = $('#editEventTitle').val();
		var eventDate = $('#editEventDate').val();
		$.post('ajax' , { type : 'editEvent' , args : { eventID : eventID , title : title , eventDate : eventDate} } , function(response){
				alert('Edit Reseveration Completed');
				initialization(month,year);
		});
	});


	//script for down button
	$("#animatePulldown").click(function() {
    	$('html, body').animate({
        	scrollTop: $("#calendar").offset().top
    	}, 2000);
	});


//functions

	function initialization(month,year){
		numRow = 0;
		$('#calendarView').html('');
		var mon = month;
		var yr = year;
		day = 1;
		week = 0;
		var date = new Date(mon + " " + day + ", " + yr).getDay();
		$('#calendarView').append("<div class='row seven-cols'>");
		switch(date){
			case 0:
				week = 1;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;

			case 1:
				week = 2;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
			
			case 2:
				week = 3;
				$('#calendarView div.row').eq(numRow).append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
			
			case 3:
				week = 4;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
			
			case 4:
				week = 5;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
			
			case 5:
				week = 6;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
			
			case 6:
				week = 7;
				$('#calendarView div.row').append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'></div><div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
			break;
		}
		calView(mon,yr);
		$.post('ajax' , { type : 'getEvents' , args : { } } , function(response){
			$.each(response,function(e){
				$('div#calendarView button[data-month="'+response[e]["month"]+'"][data-day="'+response[e]["day"]+'"][data-year="'+response[e]['year']+'"]').removeClass("btn-default").addClass("btn-primary");
			});
		},"JSON");
	}

	function calView(month,year){
		day++;
		var mon = month;
		var yr = year;
		if(day <= dayInMonth(mon,yr)){
			if(week < 7){
				$('#calendarView div.row').eq(numRow).append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
				week++;
			}else{
				week = 0;
				$('#calendarView').append("</div><div class='row seven-cols'>");
				numRow++;
				$('#calendarView div.row').eq(numRow).append("<div class='col-md-1 col-xs-1 col-sm-1 col-lg-1'><button data-month='"+mon+"' data-day='"+day+"' data-year='"+yr+"' class='btn btn-default'>"+day+"</button></div>");
				week++;
			}
			calView(mon,yr);
		}else{
			$('#calendarView').append("</div>");
		}
	}

	function dayInMonth(month,year){
		return new Date(year, month, 0).getDate();
	}

	$("#animationPulldown").click(function() {
    	$('html,body').animate({
        	scrollTop: $("#calendar").offset().top
    	});
	});

})