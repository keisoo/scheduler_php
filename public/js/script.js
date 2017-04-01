jQuery(document).ready(function($) {
   
    $(".navbar-toggle").on("click", function () {
        $(this).toggleClass("active");
    });


    $('#logout').click(function(event){
        if(confirm('Are you sure you want to logout?')){
            window.location = 'login/logout';
        }
    });


    $('#addEventHeader').click(function(e){
        e.preventDefault();
		var startDate = $('#startDate').val();
        var startTime = $('#startTime').val(); 
        var endTime = $('#endTime').val();
        var title = $('#eventTitle').val();
        var organizer = $('#organizer').val();
        var college = $('#College').val();
        // alert(startDate);

        $('div.form-group.has-error span.help-block').remove();
        $('div.form-group').removeClass('has-error');

        if(title == ''){
            $('#eventTitle').parent().addClass('has-error');
            $('div.form-group.has-error').append('<span class="help-block">This cannot be empty.</span>');
        }else if(organizer == ''){
            $('#organizer').parent().addClass('has-error');
            $('div.form-group.has-error').append('<span class="help-block">This cannot be empty.</span>');
        }else if(college == ''){
            $('#College').parent().addClass('has-error');
            $('div.form-group.has-error').append('<span class="help-block">This cannot be empty.</span>');
        }else{
            if(startTime.substring(0,2) > 7 && startTime.substring(0,2) < 17){
                if(endTime.substring(0,2) > 8 && endTime.substring(0,2) < 18){
                    $.post('ajax' , { type : 'checkEvent' , args : { startDate : startDate , startTime : startTime , endTime : endTime} } , function(response){
                        
                        if(response == 1){
                            alert("Date is booked. Choose another date.");
                        }else if(response == 2){
                            // alert("Invalid input date. Date cannot be booked earlier than the date today.");
                            $('#startDate').parent().addClass('has-error');
                            $('div.form-group.has-error').append('<span class="help-block">Date cannot be booked earlier than the date today.</span>');
                        }else if(response == 3){
                            // alert("Invalid input date. Start time cannot be earlier than end time.");
                            $('#startTime').parent().addClass('has-error');
                            $('#endTime').parent().addClass('has-error');
                            $('div.form-group.has-error').append('<span class="help-block">Start time cannot be earlier than end time.</span>');

                        }else{
                            $.post('ajax' , { type : 'addEvent' , args : { startDate : startDate , startTime : startTime , endTime : endTime , title : title , organizer : organizer , college : college }} , function(response){
                                alert("Event Added!");
                                location.reload();
                            });
                        }
                    });
                }else{
                    $('#endTime').parent().addClass('has-error');
                    $('div.form-group.has-error').append('<span id="" class="help-block">End Time must be atleast later than 8AM and earlier than 6PM </span>');
                }
            }else{
                $('#startTime').parent().addClass('has-error');
                $('div.form-group.has-error').append('<span id="" class="help-block">Start time must be atleast later than 9AM and earlier than 5PM.</span>');
            }
        }

        

		


		
	});


    var scrolled = 0;
    $("#scrolldown").on("click" ,function(){
        scrolled=scrolled+300;

    });

    $('#popover').popover({ 
        html : true,
        title: function() {
          return $("#popover-head").html();
        },
        content: function() {
          return $("#popover-content").html();
        }
    });

    var url = window.location.href;
    if(url == "http://localhost/irtc/" || url == "http://localhost/irtc/home"){
        $('li a').removeClass('active');
        $('li').find('[data-bar="home"]').addClass('active');
    }else if(url == "http://localhost/irtc/listview" || url == "http://localhost/irtc/listview/search"){
        $('li a').removeClass('active');
        $('li').find("[data-bar='view']").addClass('active');
    }else if(url == "http://localhost/irtc/administrator"){
        $('li a').removeClass('active');
        $('li').find("[data-bar='administrator']").addClass('active');
    }

});
