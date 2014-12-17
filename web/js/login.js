// Login Form

$('#modalFormSubmit').click(function(){
	//alert("Submitted form ... EBOOOOOLOOOOOOOOOOO!!!!");
    //console.log("Submitted form ... EBOOOOOLOOOOOOOOOOO!!!!");
    if ($('#title').val()==="") {
      // invalid
      $('#title').next('.help-inline').show();
      return false;
    }
    else {
      // submit the form here
      // $('#modalForm').submit();
	  alert("Submitted form ... EBOOOOOLOOOOOOOOOOO!!!!");
      
      return true;
    } 
      
});
/*

$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});
$(function() {
    var button = $('#signupButton');
    var box = $('#signupBox');
    var form = $('#signupForm');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#signupButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});
*/