/*
    File name: delete_order.js
    Functionality: implement request of deleting any order within 24 hours for customer 
            and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#delete-botton").click(function() {
        deleteOrder();
    });

    $("#delete-id").change(function() {
        isValidOrderid();
    });
});

/*
    functionality: Delete order within 24 hours which is chosen by customer.
    parameters: None
    return value: None
*/
function deleteOrder() {
    // empty msg area
    $("#message-area").empty();

    // get user input
    $request = "delete_order";
    $delete_id = $("#delete-id").val();

    // check if user input is valid
    if (isValidOrderid() === false) {
        $("#delete-id").focus();
        return;
    }
    
    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'delete_order.php',
        async: 'true',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            delete_id: $delete_id
        }),
        success: function(response) {
            if (response.status === "success") { // if order is deleted successfully, alert user and refresh the page
                alert("Delete order " + $delete_id + " successfully.");
                window.location.reload(); 
            }
            else if (response.status === "fail") { // if failed, prompt for user and focus on ordering id textbox
                $("#message-area").html("Delete failure. Please try again.");
                $("#delete-id").focus();
            }
            else if (response.status === "no_record") { // if the ordering id does not exist or does not belong to the customer
                $("#message-area").html("No such record to be deleted.");
                $("#delete-id").focus();
            }
            else if (response.status === "timeover") { // if the selected order is over 24 hours
                $("#message-area").html("Over 24 hours. The order cannot be deleted.");
                $("#delete-id").focus();
            }
            else if (response.status === "no_login") { // if user hasn't logged in, alert user and jump to login page
                alert("You haven't log in.");
                window.location.href = "../login.html";
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
    functionality: Check if the ordering id is valid.
            Ordering id can only be a positive integer.
    parameters: None
    return value: true if ordering id is valid, false otherwise.
*/
function isValidOrderid() {
    var delete_id = $("#delete-id").val();
    var reg = new RegExp("^[0-9]+$");

    var flag = false;
    if (delete_id.length === 0) {
        $("#validation-delete-id").html("Please enter the ordering ID of order that you want to delete.");
    }
    else if(reg.test(delete_id) == false) {
        $("#validation-delete-id").html("Please enter only valid ordering ID.");
    }
    else {
        $("#validation-delete-id").html("Ordering ID is valid.");
        flag = true;
    }

    return flag;
}