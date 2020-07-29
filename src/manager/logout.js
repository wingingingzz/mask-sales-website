/*
    File name: logout.js
    Functionality: implement logout request and interaction of logout request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#logout").click(function() {
        logout();
    });
});

function logout() {
    $request = "logout";

    // use ajax to interact with server-side
    $.ajax ({ 
        type: 'post',
        url: 'logout.php',
        async: 'true',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request
        }),
        success: function(response) {
            if (response.status == "success") { // if logout successfully, alert user and jump to login page
                alert("Logout successfully.");
                window.location.href = "../login.html";
            }
            else if (response.status == "no_login") { // if failed, alert user and jump to login page
                alert("You've not logged in. Please login first.");
                window.location.href = "../login.html";
            }
        },
        error: function(XMLHttpRequest, textStatus) {
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