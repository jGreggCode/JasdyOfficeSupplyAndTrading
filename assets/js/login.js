$(document).ready(function(){
	
	// Listen to register button
	$('#register').on('click', function(){
		register();
	});
	
	// Listen to reset password button
	$('#resetPasswordButton').on('click', function(){
		resetPassword();
	});
	
	// Listen to login button
	$('#login').on('click', function(){
		login();
	});

	// Listen to Forgotpass button
	$('#forgotpass').on('click', function(){
		forgotPass();
	});

	$('#changePassBtn').on('click', function(){
		changePass();
	});

	// Listen to register button
	$(document).on('click', '.addOrder', function(){
        addOrder(this);
	});

	$(document).on("click", ".removeOrder", function () {
		$(this).closest("tr").remove(); // Removes the row
		updateTotalPrice();
	});

	$(document).on("input", ".quantity-input", function () {
		const quantity = parseInt($(this).val(), 10); // Get the current quantity as an integer
		const pricePerUnit = parseFloat($(this).data("price")); // Get the original price per unit

		// If quantity is zero, remove the row
		if (quantity === 0) {
			$(this).closest("tr").remove();
		} else if (!isNaN(quantity) && !isNaN(pricePerUnit)) {
			// Otherwise, update the total price for this row
			const totalPrice = quantity * pricePerUnit;
			$(this).closest("tr").find(".total-price").text(totalPrice.toFixed(2));
		}

		updateTotalPrice();
	  });
});

function updateTotalPrice() {
  let total = 0;

  // Iterate through all rows and sum up the total price
  $(".total-price").each(function () {
    total += parseFloat($(this).text());
  });

  // Update the total row
  $("#final-total").text(total.toFixed(2)); // Format to 2 decimal places
}

function newOrder(itemNumber, itemPrice) {
	// Create a new row
	const newRow = `
    <tr>
      <th class='item-number'>${itemNumber}</th>
      <th style="width: 200px">
        <input style="padding: 0; text-align: center; width: 6rem; margin: 0 auto;" class="quantity-input form-control" type="number" value="1" min="0" data-price="${itemPrice}">
      </th>
      <th class="total-price">${itemPrice.toFixed(2)}</th>
      <th>
        <input style="padding: 0 10px;" type="button" class="removeOrder btn btn-danger removeOrder" value="Remove">
      </th>
    </tr>
  `;

  $(".all-items").append(newRow);
  updateTotalPrice();
}

function addOrder(button) {
	var buttonID = $(button).attr('id');

	// Extract the Product ID from the button's unique ID
	var productID = buttonID.split('_')[1]; // Assuming ID is "addOrder_<productID>

	$.ajax({
		url: 'model/item/addOrder.php',
		method: 'POST',
		data: {
			orderItemID: productID,
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response

			const responseData = JSON.parse(data);
			// console.log(responseData.itemName); 
			// console.log(responseData.price);

			newOrder(responseData.itemNumber, responseData.price);

		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}

function changePass() {
	var userDetailsUserPassword1 = $('#userDetailsUserPassword1').val();
	var userDetailsUserPassword2 = $('#userDetailsUserPassword2').val();
	var userDetailsUserID = $('#userID').text();

	console.log(userDetailsUserPassword1);
	console.log(userDetailsUserPassword2);
	console.log(userDetailsUserID);

	$.ajax({
		url: '../model/login/resetPassword.php',
		method: 'POST',
		data: {
			changePassword1: userDetailsUserPassword1,
			changePassword2: userDetailsUserPassword2,
			changePassUserDetailsUserID: userDetailsUserID
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response
			// Check for a success message from the server
            if (data.includes("Password reset complete")) {
                // Replace form with a success message
                $('form').html(`
                    <div class="alert alert-success">
                        Password Changed Successfully! You can now Sign In using your new password.
                    </div>
					<br>
					<div class="text-center">
						<a style="padding: .5rem 2rem; text-transform: uppercase" href="../index.php" class="btn btn-theme">Sign In</a>
					</div>
                `);
            } else {
                // Display error messages
                $('#changePass').html(data).fadeIn();
                setTimeout(function() {
                    $('#changePass').fadeOut();
                }, 2000);
            }
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}

// Function to register a new user
function register(){
	var registerFullName = $('#registerFullName').val();
	var registerUsername = $('#registerUsername').val();
	var registerUserType = $('#registerUserType').val();
	var registerEmail = $('#registerEmail').val();
	var registerPhoneNo = $('#registerPhoneNo').val();
	var registerPassword1 = $('#registerPassword1').val();
	var registerPassword2 = $('#registerPassword2').val();

	$('#loadingMessage').fadeIn();
	
	$.ajax({
		url: 'model/login/register.php',
		method: 'POST',
		data: {
			registerFullName: registerFullName,
			registerUsername: registerUsername,
			registerUserType: registerUserType, 
			registerEmail: registerEmail, 
			registerPhoneNo: registerPhoneNo,
			registerPassword1: registerPassword1,
			registerPassword2: registerPassword2,
		},
		success: function(data) {
			console.log('AJAX Response:', data); // Log the response
			$('#registerMessage').html(data).fadeIn();
			
			setTimeout(function() {
                $('#registerMessage').fadeOut();
            }, 2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		},
		complete: function() {
            // Hide the loading message once the request is complete
            $('#loadingMessage').fadeOut();
        }
	});
}

function sendRegisterEmail() {
	var registerUserType = $('#registerUserType').val();
	var registerEmail = $('#registerEmail').val();

	$.ajax({
		url: 'send.php',
		method: 'POST',
		data: {
			registerUserType: registerUserType, 
			registerEmail: registerEmail, 
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.error('AJAX Error: ', textStatus, errorThrown); // Log any errors
		}
	});
}


// Function to reset password
function resetPassword(){
	var resetPasswordUsername = $('#resetPasswordUsername').val();
	var resetPasswordPassword1 = $('#resetPasswordPassword1').val();
	var resetPasswordPassword2 = $('#resetPasswordPassword2').val();

	$('#loadingMessage').fadeIn();

	$.ajax({
		url: 'model/login/resetPassword.php',
		method: 'POST',
		data: {
			resetPasswordUsername:resetPasswordUsername,
			resetPasswordPassword1:resetPasswordPassword1,
			resetPasswordPassword2:resetPasswordPassword2,
		},
		success: function(data){
			$('#resetPasswordMessage').html(data);
		},
		complete: function() {
			$('#loadingMessage').fadeOut();
		}
	});
}


// Function to login a user
function login(){
	var loginUsername = $('#loginUsername').val();
	var loginPassword = $('#loginPassword').val();

	$('#loadingMessage').fadeIn();
	
	$.ajax({
		url: 'model/login/checkLogin.php',
		method: 'POST',
		data: {
			loginUsername:loginUsername,
			loginPassword:loginPassword,
		},
		success: function(data){
			$('#loginMessage').html(data);
			$('#loginMessage').html(data).fadeIn();
			setTimeout(function() {
                $('#loginMessage').fadeOut();
            }, 2000);
			if(data.indexOf('Login Success') >= 0){
				window.location = 'dashboard.php';
			}
		},
		complete: function() {
			$('#loadingMessage').fadeOut();
		}
	});
}

function forgotPass(){
	var loginUsername = $('#loginUsername').val();

	$('#loadingMessage').fadeIn();
	
	$.ajax({
		url: 'model/login/forgotPass.php',
		method: 'POST',
		data: {
			forgotPass:loginUsername,
		},
		success: function(data){
			$('#loginMessage').html(data).fadeIn();
			setTimeout(function() {
                $('#loginMessage').fadeOut();
            }, 3000);
		},
		complete: function() {
			$('#loadingMessage').fadeOut();
		}
	});
}