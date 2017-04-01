jQuery(document).ready(function($){

    $('#eventList').delegate(".eventDelete","click", function(){
        if(confirm("Are you sure you want to cancel this event?")){
            var id = $(this).attr('data-id');
            $.post('ajax' , { type : 'deleteEvent' , args : { id : id } } , function(response){
                alert("Event Cancelled");
                location.reload();
            });
        }
        
    });


    $('#eventList').delegate(".editEventButton","click", function(){
        var id = $(this).attr('data-id');
        // alert(id);
        $.post('ajax' , { type : 'retrieveEditEvent' , args : { id : id } } , function(response){
            // alert(response);
            $('#editEventTitle').val(response['title']);
            $('#editEventDate').val(response['startDate']);
            $('#editEventStart').val(response['startTime']);
            $('#editEventEnd').val(response['endTime']);
            $('#editEventOrganizer').val(response['organizer']);
            $('select#editEventCollege option[value="'+response['college']+'"]').attr('selected',true);
            $('#editEventId').val(id);
        },"JSON");
        
        $("#editAnEvent").modal('show');
    });


    // $('#editEventSubmit').click(function(e){
    //     alert('Event Editted');
    //     $('#editEvent').submit();
    // });

	var page = 0;
    var type2 = $('#checkType').attr('data-type');
    var search = $('#checkType').attr('data-search');
    var kind = $('#checkType').attr('data-kind');

	$.post('ajax',{type : 'events' , args : { page : 0 , type2 : type2 , search : search , kind : kind} }, function(response){
        // alert(response);
        $('#pagination').append('<center><ul class = "list-inline">');
        $('#pagination ul').append('<li class = "back"><button class="btn btn-default" data-target="back">&laquo; Prev</button></li>');
        $('.back').hide();
        var i = 0;
        page = parseInt((parseInt(response['num'])+9)/10);
        // alert(page);
        while(i < page){
            if(i == 0){
                $('#pagination ul').append('<li class = "active pages"><button class="btn btn-default" data-target="'+(i+1)+'">'+(i+1)+'</button></li>');
            }else{
                $('#pagination ul').append('<li class = "pages"><button class="btn btn-default" data-target="'+(i+1)+'">'+(i+1)+'</button></li>');
            }
            i++;
        }
        last = i;

        $('#pagination ul').append('<li class = "next"><button class="btn btn-default" data-target="next">Next &raquo;</button></li>');
        $('#pagination').append('</ul></center>');
        $('#eventList').html(response['output']);

        current = 1;

        if(current == last || last == 0){
            $('.next').hide()
        }
    },"JSON");

    $('#pagination').delegate('ul','click', function(e){
        // alert(123);
        e.preventDefault();
        $('.pages').removeClass('active');
        if($(e.target).attr('data-target') == 'next'){
            current++;
            page = parseInt(current-1);
        }else if($(e.target).attr('data-target') == 'back'){
            current--;
            page = parseInt(current-1);
        }else{
            current = $(e.target).text();
            page = parseInt($(e.target).text()-1);
        }
        if(current != 1){
            $('.back').show();
        }
        if(current == 1){
            $('.back').hide();
        }
        if(current == last){
            $('.next').hide();
        }
        if(current != last){
            $('.next').show();
        }
        $('ul li').find("[data-target='"+current+"']").parent().addClass('active');
        $('#eventList').html('');

        $.post('ajax',{type : 'events' , args : { page : page , type2 : type2 , kind : kind , search : search } }, function(response){
            $('#eventList').html(response['output']);
        },'JSON');
    });


});

