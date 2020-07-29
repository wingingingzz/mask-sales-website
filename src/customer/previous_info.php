<?php
    // File name: previous_info.php
    // Functionality: implement request of display customer information before modifying
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);
    $request = $param_obj->request;

    $response = array();

    // ensure request is to get current customer info from database
    if ($request === "get_previous_info") {
        // start session
        session_start();

        // check if user has logged in
        if(isset($_SESSION["username"]) === true) {
            $username = $_SESSION["username"];

            // connect to database
            $db_servername = "localhost";
            $db_username = "scyqw4";
            $db_password = "scyqw4";
            $db_dbname = "scyqw4";

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
            if ($conn->connect_error) {
                die("Connection failed: ".$conn->connect_error);
            }

            // get customer's current infomation
            $sql_get_info = "SELECT * FROM customer, account WHERE customer.username = '$username' AND customer.username = account.username";
            $query_result_info = $conn->query($sql_get_info);
            $row = $query_result_info->fetch_assoc();

            $response["password"] = $row['password'];
            $response["first_name"] = $row['first_name'];
            $response["last_name"] = $row['last_name'];
            $response["passport_id"] = $row['passport_id'];
            $response["region"] = $row['region'];
            $response["tel"] = $row['tel'];
            $response["email"] = $row['email'];

            // close connection to database
            $conn->close();
        }
        else {
            $response["status"] = "no_login";
        }
        // returned type is json
        echo json_encode($response);
    }
?>