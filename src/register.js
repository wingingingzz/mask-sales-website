/*
    File name: register.js
    Functionality: implement register request and interaction of register page
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#register-botton").click(function() {
        register();
    });

    $("#username").change(function() {
        isValidUserame();
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
    functionality: Send a register request to server-side.
            If it succeeds, it will jump to the login page. 
            Otherwise, it will report errors in corresponding message areas.
    parameters: None
    return value: None
*/
function register() {
    // empty msg areas
    $("#message-area").empty();

    // check if any user inputs are valid
    var allValid = new Array(isValidUserame(), isValidPassword(), isValidConfPassword(), 
            isValidFirstname(), isValidLastname(), isValidPassportId(), isValidTel(), isValidEmail());
    var isAllValid = true;
    for(var i = 0; i < 8; i++) {
        if(allValid[i] === false) {
            isAllValid = false;
            break;
        }
    }
    if(isAllValid === false) {
        $("#message-area").html("Invalid input. Please fill in or modify first.");
        return;
    }

    // get user inputs
    $request = "register";
    $username = $("#username").val();
    $password = $("#confirm-password").val();
    $firstname = $("#firstname").val();
    $lastname = $("#lastname").val();
    $passportid = $("#passport-id").val();
    $region = $("#region").val();
    $tel = $("#tel").val();
    $email = $("#email").val();

    // use ajax to interact with server-side to authenticate account
    $.ajax ({
        type: 'post',
        url: 'register.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            username: $username,
            password: $password,
            firstname: $firstname,
            lastname: $lastname,
            passportid: $passportid,
            region: $region,
            tel: $tel,
            email: $email
        }),
        success: function(response) {
            if (response.status === "success")
            {
                alert("You have successfully registered.");
                window.location.href = "login.html"; // if successfully registered, jump to login page.
            }
            else if (response.status === "fail") {
                $("#message-area").html("Register failure. Please try again.");
            }
            else if (response.status === "registered") { // if the username has been registered, prompt for user.
                $("#message-area").html("The username has been registered. Please change a username and try again.");
                $("#username").focus(); // focus on username text box.
            }
        },
        error: function(XMLHttpRequest, textStatus) {
            $("#message-area").html("Request Failure. Please try again.");
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