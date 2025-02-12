$(document).ready(function(){
	
	// Listen to register button
	$('#activate').on('click', function(){
		activateAccount();
	});

	$('#deactivate').on('click', function(){
		deactivateAccount();
	});

	$('#changePass').on('click', function(){
		changePass();
	});
	
});

function changePass() {
	var userDetailsUserID = $('#userID').text();
    var userDetailsUserPassword1 = $('#userDetailsUserOldPass').val();
    var userDetailsUserPassword2 = $('#userDetailsUserNewPass').val();

	console.log(userDetailsUserPassword1);
	console.log(userDetailsUserPassword2);
	console.log(userDetailsUserID);

	$.ajax({
		url: '../../model/login/resetPassword.php',
		method: 'POST',
		data: {
			userDetailsUserID: userDetailsUserID, 
            userDetailsUserPassword1: userDetailsUserPassword1,
            userDetailsUserPassword2: userDetailsUserPassword2
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response
			$('#changePassMessage').html(data).fadeIn();
			setTimeout(function() {
                $('#changePassMessage').fadeOut();
            }, 2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}

function activateAccount() {
	var userDetailsUserEmail = $('#userDetailsUserEmail').val();
    var userDetailsUserPosition = $('#userDetailsUserPosition').val();
    var userDetailsUserStatus = $('#userDetailsUserStatus').val();


    $.ajax({
		url: '../../send.php',
		method: 'POST',
		data: {
			userDetailsUserEmail: userDetailsUserEmail, 
            userDetailsUserPosition: userDetailsUserPosition,
            userDetailsUserStatus: userDetailsUserStatus
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response
			$('#loginMessage').html(data).fadeIn();
			setTimeout(function() {
                $('#loginMessage').fadeOut();
            }, 2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}

function deactivateAccount() {
	var userDetailsUserID = $('#userDetailsUserID').val();
	var userDetailsUserEmail = $('#userDetailsUserEmail').val();
    var userDetailsUserPosition = $('#userDetailsUserPosition').val();
    var userDetailsUserStatus = $('#userDetailsUserStatus').val();

	$.ajax({
		url: '../../send.php',
		method: 'POST',
		data: {
			deactUserDetailsUserID: userDetailsUserID,
			deactUserDetailsUserEmail: userDetailsUserEmail, 
            deactUserDetailsUserPosition: userDetailsUserPosition,
            deactUserDetailsUserStatus: userDetailsUserStatus
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response
			$('#loginMessage').html(data).fadeIn();
			setTimeout(function() {
                $('#loginMessage').fadeOut();
            }, 2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}