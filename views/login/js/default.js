jQuery(document).ready(function($) {


//toggle for the navbars
    $('[data-toggle="tooltip"]').tooltip(); 


//js for wrong password
	$('#wrongAccount').hide();


//this is for the masking and unmasking of the password
    var mask = true;
    $("#unmask").click(function(){
        if(mask === true){
            mask = false;
            $("#password").attr("type", "text");
            $("#icon").removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        }else{
            mask = true;
            $("#password").attr("type", "password");
            $("#icon").removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
    
    });

// checking accounts if exists
    $('#check_login').click(function(e){
    	e.preventDefault();
    	var user = $('#username').val();
    	var pass = $('#password').val();
    	if(user.length < 4 || pass.length < 4){
            $('#wrongAccount').show();
        }else{
    		$.post("ajax",{ type : 'login' , args: { user : user, pass : pass } },
                function(response){
                    if(response == 1) {
                        window.location.assign("home");
                        return false;
                    }
                    else{
                        // alert("Wrong Username or Password");
                        $('#wrongAccount').show();
                        $('#username').val('');
                        $('#password').val('');
                    }
                }
            );
    	}
    })
});