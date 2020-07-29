/*
    File name: modify_info.js
    Functionality: implement request for manager to assign new salesrep
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#assign-salesrep-botton").click(function() {
        assignSalesrep();
    });

    $("#salesrep-quota").change(function() {
        isValidQuota();
    });

    $("#username").change(function() {
        isValidUserame();
    });
    
    $("#password").change(function() {
        isValidPassword();
    });

    $("#firstname").change(function() {
        isValidFirstname();
    });

    $("#lastname").change(function() {
        isValidLastname();
    });

    $("#tel").change(function() {
        isValidTel();
    });

    $("#email").change(function() {
        isValidEmail();
    });
});

/*
    functionality: Send a request to server-side to assign new salesrep.
            If it succeeds, it will alert user and refresh the page. 
            Otherwise, it will report error in message area.
    parameters: None
    return value: None
*/
function assignSalesrep() {
    // empty message area
    $("#message-area").empty();

    // check if all user inputs are valid
    var allValid = new Array(isValidUserame(), isValidPassword(), isValidFirstname(), isValidLastname(), 
            isValidTel(), isValidEmail(), isValidQuota());
    var isAllValid = true;
    for(var i = 0; i < 7; i++) {
        if(allValid[i] === false) {
            isAllValid = false;
            break;
        }
    }
    if(isAllValid === false) {
        $("#message-area").html("Invalid input. Please fill in or modify first.");
        return;
    }

    // get user inputs for new salesrep
    $request = "assign_salesrep";
    $username = $("#username").val();
    $password = $("#password").val();
    $firstname = $("#firstname").val();
    $lastname = $("#lastname").val();
    $region = $("#region").val();
    $tel = $("#tel").val();
    $email = $("#email").val();
    $quota = $("#salesrep-quota").val();

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'assign_salesrep.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            username: $username,
            password: $password,
            firstname: $firstname,
            lastname: $lastname,
            region: $region,
            tel: $tel,
            email: $email,
            quota: $quota
        }),
        success: function(response) {
            if (response.status === "success") { // if assign new salesrep successfully, alert user and refresh the page
                alert("Sales rep is successfully assigned.");
                window.location.reload();
            }
            else if (response.status === "registered") { // if the username has been registered, prompt for user and focus on username text box
                $("#message-area").html("The username has been registered. Please change a username and try again.");
                $("#username").focus();
            }
            else if (response.status === "fail") { // if failed, prompt for user
                $("#message-area").html("Assign salesrep failure. Please try again.");
            }
            else if (response.status === "no_login") { // if user haven't login, prompt for user
                alert("You haven't log in.");
                window.location.href = "../login.html";
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