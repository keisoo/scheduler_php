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

    var mask2 = true;
    $("#unmask2").click(function(){
        if(mask2 === true){
            mask2 = false;
            $("#password2").attr("type", "text");
            $("#icon2").removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        }else{
            mask2 = true;
            $("#password2").attr("type", "password");
            $("#icon2").removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
    
    });

    $("#check_login").click(function(e){
        e.preventDefault();
        if($("#username").val() < 4 || $("#password").val() < 4){
            alert("Username or Password must be atleasst 4 characters long.");
        }else if($("#password").val() != $("#password2").val()){
            alert("Passwords does not match.");
        }else{
            var user = $("#username").val();
            var email = $("#email").val();
            $.post('ajax', { type : 'accountValidation' , args : { user : user , email : email } } , function(response){
                // alert(response);
                if(response == 1){
                    alert("Account Registered");
                    $("#register").submit();
                }else{
                    alert("Username or Email already taken.");
                }
            });
        }
    });

    $(".btn.deleteAccount").click(function(){
        if(confirm("Are you sure you want to delete this account?")){
            var id = $(this).attr('data-id');
            $.post('ajax' , { type : 'deleteAccount' , args : { id : id } } , function(response){
                alert('Account Deleted');
                location.reload();
            });
        }
        
    });

     $(".btn.enableAccount").click(function(){
        if(confirm("Are you sure you want to enable this account?")){
            var id = $(this).attr('data-id');
            $.post('ajax' , { type : 'enableAccount' , args : { id : id } } , function(response){
                alert('Account Enabled');
                location.reload();
            });
        }
        
    });

    $(".btn.editAccount").click(function(){
        var id = $(this).attr('data-id');
        $.post('ajax' , { type : 'getSingleUser' , args : { id : id } } , function(response){
            $('#editUsername').val(response[0]['username']);
            $('#editName').val(response[0]['name']);
            $('#editEmail').val(response[0]['email']);
            $('#editId').val(response[0]['id']);
            $('#editModal').modal('show');
        },'JSON');
    });

    $('.btn#editButton').click(function(){
        // alert(1);
        var username = $('#editUsername').val();
        var name = $('#editName').val();
        var email = $('#editEmail').val();
        var id = $('#editId').val();
        $.post('ajax' , { type : 'changeUserAccount' , args : { id : id , username : username , name : name , email : email} } , function(response){
            alert('Changes have been saved.');
            location.reload();

        });
    });
   
   $('.btn.changePass').click(function(){
        var id = $(this).attr('data-id');
        $('#changePassId').val(id);
        $('#changePassModal').modal('show');
   });  

   $('#changePassButton').click(function(){
        var oldPass = $('#oldPassword').val();
        var newPass = $('#newPassword').val();
        var newPass2 = $('#newPassword2').val();
        var id = $('#changePassId').val();
        $('div.form-group.has-error span.help-block').remove();
        $('div.form-group').removeClass('has-error');
        $.post('ajax' , { type : 'changePassword' , args : { id : id , oldPass : oldPass , newPass : newPass , newPass2 : newPass2} } , function(response) {
            if(response == 0){
                $('#oldPassword').parent().addClass('has-error');
                $('div.form-group.has-error').append('<span class="help-block">Invalid Password</span>');
            }else if(response == 1){
                $('#newPassword').parent().addClass('has-error');
                $('#newPassword2').parent().addClass('has-error');
                $('div.form-group.has-error').append('<span class="help-block">Passwords do not match.</span>');
            }else{
                alert('Password changed.');
                $('#oldPassword').val('');
                $('#newPassword').val('');
                $('#newPassword2').val('');
                $('#changePassModal').modal('toggle');

            }
        });
   });



});