/*
    File name: modify_info.js
    Functionality: implement request for customer to update/modify information and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    // update customer info
    getPreInfo();

    $("#modify-botton").click(function() {
        modifyInfo();
    });

    $("#password").change(function() {
        isValidPassword();
    });

    $("#confirm-password").change(function() {
        isValidConfPassword();
    });

    $("#firstname").change(function() {
        isValidFirstname();
    });

    $("#lastname").change(function() {
        isValidLastname();
    });

    $("#passport-id").change(function() {
        isValidPassportId();
    });

    $("#tel").change(function() {
        isValidTel();
    });

    $("#email").change(function() {
        isValidEmail();
    });
});

/*
    functionality: Get current customer info from database and display on the page
    parameters: None
    return value: None
*/
function getPreInfo() {
    $request = "get_previous_info";

    // use ajax to interact with server-side to authenticate account
    $.ajax ({
        type: 'post',
        url: 'previous_info.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request
        }),
        success: function(response) {
            if (response.status == "no_login") { // if user hasn't log in, alert user and jump to login page
                alert("You haven't log in.");
                window.location.href = "../login.html";
            }
            else { // display current customer info on the page
                $("#password").val(response.password);
                $("#confirm-password").val(response.password);
                $("#firstname").val(response.first_name);
                $("#lastname").val(response.last_name);
                $("#passport-id").val(response.passport_id);
                $("#region").val(response.region);
                $("#tel").val(response.tel);
                $("#email").val(response.email);
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
    functionality: Update customer info and save modidied info into database
    parameters: None
    return value: None
*/
function modifyInfo() {
    // empty msg areas
    $("#message_area").empty();

    // check if user inputs are valid
    var allValid = new Array(isValidPassword(), isValidConfPassword(), 
            isValidFirstname(), isValidLastname(), isValidPassportId(), isValidTel(), isValidEmail());
    var isAllValid = true;
    for(var i = 0; i < 8; i++) {
        if(allValid[i] === false) {
            isAllValid = false;
            break;
        }
    }
    if(isAllValid === false) {
        $("#message_area").html("Invalid input. Please fill in or modify first.");
        return;
    }

    // get user inputs
    $request = "modify_info";
    $password = $("#confirm-password").val();
    $firstname = $("#firstname").val();
    $lastname = $("#lastname").val();
    $passportid = $("#passport-id").val();
    $region = $("#region").val();
    $tel = $("#tel").val();
    $email = $("#email").val();

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'modify_info.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            password: $password,
            firstname: $firstname,
            lastname: $lastname,
            passportid: $passportid,
            region: $region,
            tel: $tel,
            email: $email
        }),
        success: function(response) {
            if (response.status === "success") { // if update successfully, alert user and jump to home page of customer
                alert("You've successfully saved changes.");
                window.location.href = "customer.php";
            }
            else if (response.status === "fail") { // if failed, prompt for user to try again
                $("#message-area").html("Modification failure. Please try again.");
            }
            else if (response.status === "no_login") { // if user does not logged in, alert user
                alert("You haven't logged in.");
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