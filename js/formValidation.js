$(document).ready(function() {
 
  $(".multi").select2({
    placeholder: "Select team"
  });


  $('#form').submit(function(e) {
    e.preventDefault();
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('#email').val();
    var phone_number = $('#phone').val();
    var comments_window = $('#comments_window').val();

    $(".error").remove();
 
    if (first_name.length < 1) {
      $('#first_name').after('<span class="error">  This field is required</span>');

    }
    if (last_name.length < 1) {
      $('#last_name').after('<span class="error">  This field is required</span>');

    }  
    if (email.indexOf("@") < 1 || email.length < 2) {
      $('#email').after('<span class="error">  Enter a valid email</span>');

    }
    if (phone_number.length < 2) {
      $('#phone').after('<span class="error">  Enter phone number</span>');	

    }
    if (comments_window.length < 1) {
      $('#comments_window').after('<span class="error">  Enter a comment</span>');

  }
  }); 

});




	

	
