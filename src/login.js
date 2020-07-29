/*
    File name: login.js
    Functionality: implement login request and interaction of login page
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    chkCookies();

    $("#login").click(function() {
        saveCookies();
        login();
    });

    $("#username").keyup(function() {
        focusNext(event);
    });

    $("#password").keyup(function() {
        loginWhenReturn(event);
    });
});

/*
    functionality: Check if user have chosen to remember username and password.
            If so, directly display them on login page.
    parameters: None
    return value: None
*/
function chkCookies() {
    // check if user have chosen to remember username and password.
    if($.cookie('remember')) {
        $("#remember").prop("checked", true);
        $("#username").val($.cookie("username"));
        $("#password").val($.cookie("password"));
    }
}

/*
    functionality: If user choose to remember username and password, save them in cookie.
    parameters: None
    return value: None
*/
function saveCookies() {
    // check if user choose to remember or not
    if ($("#remember").prop("checked")) { // after jquery version 1.6, use "prop" to check if checkbox is checked
        $username = $("#username").val();
        $password = $("#password").val();

        $.cookie("remember", "true", {expires: 7}); // expired in 7 days
        $.cookie("username", $username, {expires: 7});
        $.cookie("password", $password, {expires: 7});
    }
    else {
        $.cookie("remember", "false", {expires: -1});
        $.cookie("username", "", { expires: -1});
        $.cookie("password", "", { expires: -1});
    }
}

/*
    functionality: Send a login request to server-side.
            If it succeeds, it will jump to the corresponding page. 
            Otherwise, it will report error in message area.
    parameters: None
    return value: None
*/
function login() {
    // empty message area
    $("#message-area").empty();

    // get user inputs
    $request = "login";
    $username = $("#username").val();
    $password = $("#password").val();

    // check if user inputs are empty
    if ($username === "")
    {
        $("#message-area").html("Username cannot be empty.");
        $("#username").focus();
    }
    else if ($password === "") {
        $("#message-area").html("Password cannot be empty.");
        $("#password").focus();
    }
    else {
        // use ajax to interact with server-side
        $.ajax ({
            type: 'post',
            url: 'login.php',
            async: 'false',
            contentType: 'application/json', // param type is json
            dataType: 'json', // returned type is json
            data: JSON.stringify({ // convert param type to json
                request: $request,
                username: $username,
                password: $password
            }),
            success: function(response) {
                if (response.status === "incorrect") // if password is incorrect, prompt for user and focus on password text box.
                {
                    $("#message-area").html("Password is incorrect.");
                    $("#password").focus(); 
                }
                else if (response.status === "inexistent") { // if username does not exist, prompt for user and focus on username text box.
                    $("#message-area").html("Username does not exist.");
                    $("#username").focus(); 
                }
                else if (response.user_type === "manager") { // if user type is manager, jump to manager page.
                    window.location.href = "manager/manager.php";
                }
                else if (response.user_type === "customer") { // if user type is customer, jump to customer page.
                    window.location.href = "customer/customer.php";
                }
                else if (response.user_type === "salesrep") { // if user type is salesrep, jump to salesrep page.
                    window.location.href = "salesrep/salesrep.php";
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
    }
    return;
}

/*
    functionality: If user press "Enter" key in "username" textbox, 
            focus on password text box. 
    parameters: HTMLEvent
    return value: None
*/
function focusNext(event) {
    if (event.keyCode == 10 || event.keyCode == 13) {
        $("#password").focus();
    }
}

/*
    functionality: If user press "Enter" key in "password" textbox, 
            call "login()" function. 
    parameters: HTMLEvent
    return value: None
*/
function loginWhenReturn(event) {
    if (event.keyCode == 10 || event.keyCode == 13) {
        login();
    }
}