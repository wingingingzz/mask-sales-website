<?php
    // File name: authenticate.php
    // Functionality: implement server-side validation and data exchange for authentication request
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json fata from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);
    $request = $param_obj->request;
    $password = $param_obj->password;

    $response = array();

    // ensure request is authentication
    if ($request === "authenticate") {
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

            // check if password is correct
            $sql_authenticate = "SELECT password FROM account WHERE username = '$username'";
            $query_result_authenticate = $conn->query($sql_authenticate);
            $row = $query_result_authenticate->fetch_assoc();

            if ($row['password'] === $password) {
                $response["status"] = "success";
            }
            else {
                $response["status"] = "incorrect";
            }
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