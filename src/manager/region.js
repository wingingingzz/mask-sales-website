/*
    File name: region.js
    Functionality: implement request for manager to assign chosen salesrep to a region and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#modify-region-botton").click(function() {
        modifyRegion();
    });

    $("#employee-id").change(function() {
        isValidEmployeeid();
    });
});

/*
    functionality: Send a request to server-side to modify the region of salesrep chosen by manager.
            If it succeeds, alert user and refresh the page. 
            Otherwise, it will report error in message area.
    parameters: None
    return value: None
*/
function modifyRegion() {
    // empty msg area
    $("#message-area").empty();

    // check if user input is valid
    if(isValidEmployeeid() === false) {
        $("#message-area").html("Invalid input. Please fill in or modify first.");
        return;
    }

    // get user inputs for region modification 
    $request = "modify_region";
    $employee_id = $("#employee-id").val();
    $region = $("#salesrep-region").val();

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'modify_region.php',
        async: 'false',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request,
            employee_id: $employee_id,
            region: $region
        }),
        success: function(response) {
            if (response.status === "success") { // if modify region successfully, alert user and refresh the page
                alert("Region for salesrep " + $employee_id + " is successfully modified to " + $region + ".");
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