<?php

    // File name: login.php
    // Functionality: implement server-side validation and data exchange for login request
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);

    $request = $param_obj->request;
    $username = $param_obj->username;
    $password = $param_obj->password;

    $response = array();

    // ensure request is login
    if ($request === "login") {

        // connect to database
        $db_servername = "localhost";
        $db_username = "scyqw4";
        $db_password = "scyqw4";
        $db_dbname = "scyqw4";

        $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        // select account with given username
        $sql_select_account = "SELECT * FROM account WHERE username = '$username'";
        $query_result_account = $conn->query($sql_select_account);

        $row = $query_result_account->fetch_assoc(); // username is primary key, so only one row

        // check if username and password match data in database
        if ($row['username'] === $username && $row['password'] === $password) {

            // start session
            session_start();
            $_SESSION["username"] = $username; // if match, save username in session

            $response["user_type"] = $row['user_type'];
        }
        else if ($row['username'] === $username && $row['password'] != $password) {
            $response["status"] = "incorrect";
        }
        else {
            $response["status"] = "inexistent";
        }

        // returned type is json
        echo json_encode($response);

        // close connection to database
        $conn->close();
    }
?>