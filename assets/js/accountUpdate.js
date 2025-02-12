$(document).ready(function() {

    $('#updateBtn').on('click', function() {
        // Call submitDelete function
        var accountID = $('#userID').text();
        if (accountID == 'No user') {
            bootbox.alert("There is no user selected!");
            exit();
        }

        const phonePattern = /^(?:\+63|0|63)9\d{9}$/;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        var customerDetailsEmail = $('#userDetailsUserEmail').val();
        var customerDetailsPhone = $('#userDetailsUserMobile').val();
        var messageLog = $('#message');

        // Validation
        if (!phonePattern.test(customerDetailsPhone)) {
            message = 'Invalid phone number. Please use +639xxxxxxxxx or 09xxxxxxxxx.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        } 

        if (!emailPattern.test(customerDetailsEmail)) {
            message = 'Invalid email address. Please enter a valid one.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        }

        bootbox.confirm('Are you sure you want to update ' + '(UID: ' + accountID + ')', function(result){
			if(result){
				submitUpdate();
			}
		});
    });

    $('#deleteBtn').on('click', function() {
        // Call submitDelete function
        var accountID = $('#userID').text();
        if (accountID == 'No user') {
            bootbox.alert("There is no user selected!");
            return;
        }

        bootbox.confirm('Are you sure you want to delete ' + '(UID: ' + accountID + ')', function(result){
			if(result){
				submitDelete();
			}
		});
    });

    $('#activateBtn').on('click', function() {
        // Call submitDelete function
        var accountID = $('#userID').text();
        if (accountID == 'No user') {
            bootbox.alert("There is no user selected!");
            exit();
        }

        bootbox.confirm('Are you sure you want to activate ' + '(UID: ' + accountID + ')', function(result){
			if(result){
				submitActivate();
			}
		});
    });

    $('#deactivateBtn').on('click', function() {
        // Call submitDelete function
        var accountID = $('#userID').text();
        if (accountID == 'No user') {
            bootbox.alert("There is no user selected!");
            exit();
        }

        bootbox.confirm('Are you sure you want to deactivate ' + '(UID: ' + accountID + ')', function(result){
			if(result){
				submitDeactivate();
			}
		});
    });

});

// Update account details
function submitUpdate() {
    var updateUserID = $('#userID').text();
    var updateUserDetailsUserFullName = $('#userDetailsUserFullName').val();
    var updateUserDetailsUserUsername = $('#userDetailsUserUsername').val();
    var updateUserDetailsUserEmail = $('#userDetailsUserEmail').val();
    var updateUserDetailsUserMobile = $('#userDetailsUserMobile').val();
    var updateUserDetailsUserLocation = $('#userDetailsUserLocation').val();
    var updateUserDetailsUserOldPass = $('#userDetailsUserOldPass').val();
    var updateUserDetailsUserNewPass = $('#userDetailsUserNewPass').val();
    // Admin Priviledge
    var updateUserDetailsUserType = $('#userDetailsUserPosition').val();
    var updateUserDetailsUserStatus = $('#userDetailsUserStatus').val();
    var updateUserDetailsUserPosition = $('#userDetailsUserPosition').val();
    
    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/accounts/AccountManagerController.php',
        method: 'POST',
        data: {
            updateUserID: updateUserID,
            updateUserDetailsUserFullName: updateUserDetailsUserFullName,
            updateUserDetailsUserUsername: updateUserDetailsUserUsername,
            updateUserDetailsUserEmail: updateUserDetailsUserEmail,
            updateUserDetailsUserMobile: updateUserDetailsUserMobile,
            updateUserDetailsUserLocation: updateUserDetailsUserLocation,
            updateUserDetailsUserOldPass: updateUserDetailsUserOldPass,
            updateUserDetailsUserNewPass: updateUserDetailsUserNewPass,
            // ADMIN
            updateUserDetailsUserType: updateUserDetailsUserType,
            updateUserDetailsUserStatus: updateUserDetailsUserStatus,
            updateUserDetailsUserPosition: updateUserDetailsUserPosition
        },
        success: function(data) {
            console.log('AJAX Response: ', data);
            var result = JSON.parse(data);
            var message = result.message;
            var messageLog = $('#message');

            if (result.status === 'success') {
                messageLog.html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'warning') {
                messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'error') {
                messageLog.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            }

			setTimeout(function() {
                messageLog.fadeOut();
            }, 3000);
        },
        complete: function() {
            $('#userDetailsUserStatus').val('Disabled');
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });

}

// Delete the account
function submitDelete() {
    var deleteAccountID = $('#userID').text();

    $.ajax({
        url: '../../model/accounts/AccountManagerController.php',
        method: 'POST',
        data: {
            deleteUsingAccountID: deleteAccountID
        },
        success: function(data) {
            console.log('AJAX Response: ', data);
            var result = JSON.parse(data);
            var message = result.message;
            var messageLog = $('#message');

            if (result.status === 'success') {
                messageLog.html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'warning') {
                messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'error') {
                messageLog.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            }

			setTimeout(function() {
                messageLog.fadeOut();
            }, 3000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function submitDeactivate() {
    var accountID = $('#userID').text();
    var deactivateAccountEmail = $('#userDetailsUserEmail').val();
    var deactivateAccountType = $('#userDetailsUserPosition').val();
    var deactivateAccountStatus = $('#userDetailsUserStatus').val();

    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/accounts/AccountManagerController.php',
        method: 'POST',
        data: {
            accountID: accountID,
            deactivateAccountEmail: deactivateAccountEmail,
            deactivateAccountType: deactivateAccountType,
            deactivateAccountStatus: deactivateAccountStatus,
        },
        success: function(data) {
            console.log('AJAX Response: ', data);
            var result = JSON.parse(data);
            var message = result.message;
            var messageLog = $('#message');

            if (result.status === 'success') {
                messageLog.html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'warning') {
                messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'error') {
                messageLog.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            }

			setTimeout(function() {
                messageLog.fadeOut();
            }, 3000);
        },
        complete: function() {
            $('#userDetailsUserStatus').val('Disabled');
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

// Activate the account and sending Activation Email
function submitActivate() {
    var accountID = $('#userID').text();
    var activateAccountEmail = $('#userDetailsUserEmail').val();
    var activateAccountType = $('#userDetailsUserPosition').val();
    var activateAccountStatus = $('#userDetailsUserStatus').val();

    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/accounts/AccountManagerController.php',
        method: 'POST',
        data: {
            accountID: accountID,
            activateAccountEmail: activateAccountEmail,
            activateAccountType: activateAccountType,
            activateAccountStatus: activateAccountStatus,
        },
        success: function(data) {
            console.log('AJAX Response: ', data);
            var result = JSON.parse(data);
            var message = result.message;
            var messageLog = $('#message');

            if (result.status === 'success') {
                messageLog.html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'warning') {
                messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            } else if (result.status === 'error') {
                messageLog.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            }

			setTimeout(function() {
                messageLog.fadeOut();
            }, 3000);
        },
        complete: function() {
            $('#userDetailsUserStatus').val('Active');
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

