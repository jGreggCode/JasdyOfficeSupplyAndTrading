$(document).ready(function() {

    $('#reloadDataBtn').on('click', function() {
        reloadData();
    });

    $('#itemDeleteBtn').on('click', function() {
        var itemID = $('#productID').text();
        if (itemID == 'No Item') {
            bootbox.alert("There is no Item selected!");
            exit();
        }

        bootbox.confirm('Are you sure you want to delete ' + '(IID: ' + itemID + ')', function(result){
			if(result){
				itemDelete();
			}
		});
    });

    $('#itemUpdateBtn').on('click', function() {
        var itemID = $('#productID').text();
        if (itemID == 'No Item') {
            bootbox.alert("There is no Item selected!");
            exit();
        }

        bootbox.confirm('Are you sure you want to update ' + '(IID: ' + itemID + ')', function(result){
			if(result){
				itemUpdate();
			}
		});
    });

    $('#customerDeleteBtn').on('click', function() {
        var customerID = $('#customerID').text();

        if (customerID == 'No Item') {
            bootbox.alert("There is no Item selected!");
            return;
        }

        bootbox.confirm('Are you sure you want to delete ' + '(CID: ' + customerID + ')', function(result){
			if(result){
				customerDelete();
			}
		});
        
    });

    $('#customerUpdateBtn').on('click', function() {
        const phonePattern = /^(?:\+63|0|63)9\d{9}$/;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        var customerID = $('#customerID').text();
        var customerDetailsEmail = $('#customerDetailsEmail').val();
        var customerDetailsPhone = $('#customerDetailsPhone').val();
        var customerDetailsPhone2 = $('#customerDetailsPhone2').val();
        var messageLog = $('#message');

        console.log("Hello " + phonePattern.test(customerDetailsPhone));

        // Validation
        if (!phonePattern.test(customerDetailsPhone) ||  !phonePattern.test(customerDetailsPhone2)) {
            message = 'Invalid phone number. Please use +639xxxxxxxxx or 09xxxxxxxxx.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        } 

        if (!emailPattern.test(customerDetailsEmail)) {
            message = 'Invalid email address. Please enter a valid one.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        }

        if (customerID == 'No Item') {
            bootbox.alert("There is no Customer selected!");
            return;
        }

        bootbox.confirm('Are you sure you want to update ' + '(CID: ' + customerID + ')', function(result){
			if(result){
				customerUpdate();
			}
		});
    })

    $('#vendorDeleteBtn').on('click', function() {
        var vendorID = $('#vendorID').text();
        if (vendorID == 'No Item') {
            bootbox.alert("There is no Vendor selected!");
            return;
        }

        bootbox.confirm('Are you sure you want to delete ' + '(VID: ' + vendorID + ')', function(result){
			if(result){
				vendorDelete();
			}
		});
    });

    $('#vendorUpdateBtn').on('click', function() {
        const phonePattern = /^(?:\+63|0|63)9\d{9}$/;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        var vendorID = $('#vendorID').text();
        var vendorDetailsEmail = $('#vendorDetailsEmail').val();
        var vendorDetailsPhone = $('#vendorDetailsPhone').val();
        var vendorDetailsPhone2 = $('#vendorDetailsPhone2').val();
        var messageLog = $('#message');

        // Validation
        if (!phonePattern.test(vendorDetailsPhone) || !phonePattern.test(vendorDetailsPhone2)) {
            message = 'Invalid phone number. Please use +639xxxxxxxxx or 09xxxxxxxxx.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        } 

        if (!emailPattern.test(vendorDetailsEmail)) {
            message = 'Invalid email address. Please enter a valid one.';
            messageLog.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button>' + message + '</div>').fadeIn();
            return;
        }

        if (vendorID == 'No Item') {
            bootbox.alert("There is no Supplier selected!");
            return;
        }

        bootbox.confirm('Are you sure you want to update ' + '(SID: ' + vendorID + ')', function(result){
			if(result){
				vendorUpdate();
			}
		});
    });
});

function reloadData() {
    var profileSales = $('#profileSales').text();
    var profileSold = $('#profileSold').text();
    var profileCompanySales = $('#profileCompanySales').text();
    var profileCompanyCustomers = $('#profileCompanyCustomers').text();
    var profileCompanyExpense = $('#profileCompanyExpense').text();

    $('#loadingMessage').fadeIn();

    $.ajax({
        url: 'model/management/ManagementController.php',
        method: 'POST',
        data: {
            profileSales: profileSales,
            profileSold: profileSold,
            profileCompanySales: profileCompanySales,
            profileCompanyCustomers: profileCompanyCustomers,
            profileCompanyExpense: profileCompanyExpense
        },
        success: function(response) {
            console.log('AJAX Response: ', response);
            var data = JSON.parse(response);
            $('#profileSales').text(data.sales);
            $('#profileSold').text(data.sold);
            $('#profileCompanySales').text(data.companySales);
            $('#profileCompanyCustomers').text(data.companyCustomers);
            $('#profileCompanyExpense').text(data.companyExpense);
        },
        complete: function() {
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function vendorUpdate() {
    var updateUsingVendorID = $('#vendorID').text();
    var updateUsingVendorFullName = $('#vendorDetailsFullName').val();
    var updateUsingVendorEmail = $('#vendorDetailsEmail').val();
    var updateUsingVendorMobile = $('#vendorDetailsPhone').val();
    var updateUsingVendorMobile2 = $('#vendorDetailsPhone2').val();
    var updateUsingVendorAddress = $('#vendorDetailsAddress').val();
    var updateUsingVendorAdress2 = $('#vendorDetailsAddress2').val();
    var updateUsingVendorCity = $('#vendorDetailsCity').val();
    var updateUsingVendorDistrict = $('#vendorDetailsDistrict').val();
    
    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            updateUsingVendorID: updateUsingVendorID,
            updateUsingVendorFullName: updateUsingVendorFullName,
            updateUsingVendorEmail: updateUsingVendorEmail,
            updateUsingVendorMobile: updateUsingVendorMobile,
            updateUsingVendorMobile2: updateUsingVendorMobile2,
            updateUsingVendorAddress: updateUsingVendorAddress,
            updateUsingVendorAddress2: updateUsingVendorAdress2,
            updateUsingVendorCity: updateUsingVendorCity,
            updateUsingVendorDistrict: updateUsingVendorDistrict
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function vendorDelete() {
    var vendorID = $('#vendorID').text();

    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            deleteUsingVendorID: vendorID,
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function customerUpdate() {
    var updateUsingCustomerID = $('#customerID').text();
    var updateUsingCustomerFullName = $('#customerDetailsFullName').val();
    var updateUsingCustomerEmail = $('#customerDetailsEmail').val();
    var updateUsingCustomerMobile = $('#customerDetailsPhone').val();
    var updateUsingCustomerMobile2 = $('#customerDetailsPhone2').val();
    var updateUsingCustomerAddress = $('#customerDetailsAddress').val();
    var updateUsingCustomerAdress2 = $('#customerDetailsAddress2').val();
    var updateUsingCustomerCity = $('#customerDetailsCity').val();
    var updateUsingCustomerDistrict = $('#customerDetailsDistrict').val();
    console.log(updateUsingCustomerAdress2);
    
    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            updateUsingCustomerID: updateUsingCustomerID,
            updateUsingCustomerFullName: updateUsingCustomerFullName,
            updateUsingCustomerEmail: updateUsingCustomerEmail,
            updateUsingCustomerMobile: updateUsingCustomerMobile,
            updateUsingCustomerMobile2: updateUsingCustomerMobile2,
            updateUsingCustomerAddress: updateUsingCustomerAddress,
            updateUsingCustomerAdress2: updateUsingCustomerAdress2,
            updateUsingCustomerCity: updateUsingCustomerCity,
            updateUsingCustomerDistrict: updateUsingCustomerDistrict
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function customerDelete() {
    var deleteUsingCustomerID = $('#customerID').text();

    $('#loadingMessage').fadeIn();
    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            deleteUsingCustomerID: deleteUsingCustomerID
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });

}

function itemUpdate() {
    var itemDetailsItemProductID = $('#productID').text();
    var itemDetailsItemNumber = $('#itemDetailsItemNumber').val();
    var itemDetailsItemName = $('#itemDetailsItemName').val();
    var itemDetailsItemCategory = $('#itemDetailsItemCategory').val();
    var itemDetailsItemDescription = $('#itemDetailsItemDescription').val();
    var itemDetailsItemStock = $('#itemDetailsItemStock').val();
    var itemDetailsItemCosting = $('#itemDetailsItemCosting').val();
    var itemDetailsItemUnitPrice = $('#itemDetailsItemUnitPrice').val();

    $('#loadingMessage').fadeIn();

    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            updateUsingProductID: itemDetailsItemProductID,
            updateUsingItemNumber: itemDetailsItemNumber,
            updateUsingItemName: itemDetailsItemName,
            updateUsingItemCategory: itemDetailsItemCategory,
            updateUsingItemDescription: itemDetailsItemDescription,
            updateUsingItemStock: itemDetailsItemStock,
            updateUsingItemCosting: itemDetailsItemCosting,
            updateUsingItemUnitPrice: itemDetailsItemUnitPrice
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}

function itemDelete() {
    var deleteUsingItemID = $('#productID').text();

    $('#loadingMessage').fadeIn();
    $.ajax({
        url: '../../model/management/ManagementController.php',
        method: 'POST',
        data: {
            deleteUsingItemID: deleteUsingItemID
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
            $('#loadingMessage').fadeOut();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error: ', textStatus, errorThrown);
        }
    });
}