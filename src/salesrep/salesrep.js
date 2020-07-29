/*
    File name: salesrep.js
    Functionality: implement request of deleting orders with anomalies within 24 hours for salesrep 
            and interaction of this request
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
*/

$(document).ready(function() {
    $("#delete-anomaly-button").click(function() {
        deleteAnomaly();
    });
});

/*
    functionality: Delete all anomaly orders within 24 hours.
    parameters: None
    return value: None
*/
function deleteAnomaly() {
    // empty msg area
    $("#message-area").empty();

    $request = "delete_anomaly";

    // use ajax to interact with server-side
    $.ajax ({
        type: 'post',
        url: 'delete_anomaly.php',
        async: 'true',
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify({
            request: $request
        }),
        success: function(response) {
            if (response.status == "success") { // if delete successfully, alert salesrep and refresh the current page
                alert("Delete " + response.delete_no + " records successfully.");
                window.location.reload();
            }
            else if (response.status == "no_record") { // if there's no records that meet delete requirements
                $("#message-area").html("No such record to be deleted.");
            }
            else if (response.status == "no_login") { // if the user haven't logged in, alert user and jump to login page
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