/*
    File name: quota.js
    Functionality: implement request for manager to modify quota of chosen salesrep and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#modify-quota-botton").click(function() {
        modifyQuota();
    });

    $("#employee-id").change(function() {
        isValidEmployeeid();
    });

    $("#salesrep-quota").change(function() {
        isValidQuota();
    });
});

/*
    functionality: Send a request to server-side to modify quota of salesrep chosen by manager.
            If it succeeds, alert user and refresh the page. 
            Otherwise, it will report error in message area.
    parameters: None
    return value: None
*/
function modifyQuota() {
    // empty msg area
    $("#message-area").empty();

    // check if user inputs are valid
    if(isValidEmployeeid() === false) {
        $("#message-area").html("Invalid input. Please fill in or modify first.");
        $('#employee-id').focus();
        return;
    }
    if(isValidQuota() === false) {
        $("#message-area").html("Invalid input. Please fill in or modify first.");
        $('#salesrep-quota').focus();
        return;
    }

    // get user inputs for quota modification
    $request = "modify_quota";
    $employee_id = $("#employee-id").val();
    $quota = $("#salesrep-quota").val();

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'modify_quota.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            employee_id: $employee_id,
            quota: $quota
        }),
        success: function(response) {
            if (response.status === "success") { // if quota is modified successfully, alert user and refresh the page
                alert("Quota for salesrep " + $employee_id + " is successfully modified to " + $quota + ".");
                window.location.reload();
            }
            else if (response.status === "no_salesrep") { // if the selected salesrep does not exist, prompt for user and focus on "employee ID" text box
                $("#message-area").html("The salesrep does not exist.");
                $("#employee-id").focus();
            }
            else if (response.status === "fail") { // if failed, prompt for user to try again
                $("#message-area").html("Update failure. Please try again.");
            }
            else if (response.status === "no_login") { // if user haven't logged in, prompt for user
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