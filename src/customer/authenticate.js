/*
    File name: authenticate.js
    Functionality: implement authentication request for customer to authenticate password 
            before modify their information and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#check-password-botton").click(function() {
        checkPassword();
    });

    $("#password").change(function() {
        isValidPassword();
    });
});

/*
    functionality: Authenticate user's password before the user can update his/her infomation.
    parameters: None
    return value: None
*/
function checkPassword() {
    // empty message areas
    $("#message-area").empty();
    $("#validation-password").empty();

    // get user inputs
    $request = "authenticate";
    $password = $("#password").val();

    // check if password is valid
    if (isValidPassword() === false) {
        $("#password").focus();
        return;
    }

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'authenticate.php',
        async: 'true',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            password: $password
        }),
        success: function(response) {
            if (response.status === "incorrect") { // if password is incorrect, prompt for user and focus on password textbox
                $("#message-area").html("Authentication failure. Your password is incorrect.");
                $("#password").focus();
            }
            else if (response.status === "success") { // if authentication is successful, jump to modify_info page
                window.location.href = "modify_info.html";
            }
            else if (response.status === "no_login") { // if user hasn't logged in, prompt for user and jump to login page
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