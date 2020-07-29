/*
    File name: home_page.js
    Functionality: implement request of ordering masks and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#order-botton").click(function() {
        order();
    });

    $("#quantity").change(function() {
        isValidQuantity();
    });

    $("#employee-id").change(function() {
        isValidEmployeeid();
    });
});

/*
    functionality: Order masks if customer choose a salesrep in the same region.
    parameters: None
    return value: None
*/
function order() {

    // empty message areas
    $("#message-area").empty();
    $("#validation-quantity").empty();
    $("#validation-employee-id").empty();

    // check if input for quantity and employee id of salesrep are legal
    if(isValidQuantity() === false) {
        $("#quantity").focus();
        return;
    }
    if(isValidEmployeeid() === false) {
        $("#employee-id").focus();
        return;
    }
    
    // get user inputs
    $request = "order";
    $mask_type = $("#mask-type").val();
    $quantity = $("#quantity").val();
    $employee_id = $("#employee-id").val();

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'home_page.php',
        async: 'true',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            mask_type: $mask_type,
            quantity: $quantity,
            employee_id: $employee_id
        }),
        success: function(response) {
            if (response.status == "no_login") { // if customer hasn't logged in, alert customer and jump to login page
                alert("You haven't log in.");
                window.location.href = "../login.html";
            }
            else if (response.status == "success") { // if ordered successfully, alert customer how much he/she has paid and refresh the page
                alert("Ordered successfully. " + "You've paid " + response.sales_amount + " RMB."); 
                window.location.reload(); 
            }
            else if (response.status == "no_salesrep") { // if the employee id that is entered by customer does not exist, prompt for user and focus on employee-id text box
                $("#message-area").html("You're unable to select this sales representative. Please select again.");
                $("#employee-id").focus();
            }
            else if (response.status == "fail") {
                $("#message-area").html("Order failure. Please try again.");
            }
        },
        error: function(XMLHttpRequest, textStatus) {
            $("#message-area").html("Request Failure. Try again.");
            // status
            console.log(XMLHttpRequest.status);
            // readyState
            console.log(XMLHttpRequest.readyState);
            // err info
            console.log(textStatus);
        }
    });
    return;
}

/*
    functionality: Check if the quantity of mask purchased is valid.
            Quantity can only be a positive integer.
    parameters: None
    return value: true if quantity is valid, false otherwise.
*/
function isValidQuantity() {
    var quantity = $("#quantity").val();
    var reg = new RegExp("^[0-9]+$");

    var flag = false;
    if (quantity.length === 0) {
        $("#validation-quantity").html("Please enter quantity of masks you want to purchase.");
    }
    else if (reg.test(quantity) == false) {
        $("#validation-quantity").html("Please enter only positive integer.");
    }
    else {
        $("#validation-quantity").html("Quantity is valid.");
        flag = true;
    }

    return flag;
}