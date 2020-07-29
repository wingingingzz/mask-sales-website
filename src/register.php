<?php
    // File name: register.php
    // Functionality: implement server-side validation and data exchange for register request
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
    $firstname = $param_obj->firstname;
    $lastname = $param_obj->lastname;
    $passportid = $param_obj->passportid;
    $region = $param_obj->region;
    $tel = $param_obj->tel;
    $email = $param_obj->email;
    $user_type = "customer";

    $response = array();

    // ensure request is register
    if ($request === "register") {

        // connect to database
        $db_servername = "localhost";
        $db_username = "scyqw4";
        $db_password = "scyqw4";
        $db_dbname = "scyqw4";

        $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        // check if user name has already registered
        $sql_search_username = "SELECT username FROM account WHERE username = '$username'";
        $query_result_username = $conn->query($sql_search_username);
        $nrow = $query_result_username->num_rows;
        if ($nrow > 0) {
            $response["status"] = "registered";
        }
        else {
            $sql_insert_account = "INSERT INTO account (username, password, user_type) VALUES ('$username', '$password', '$user_type')";
            $sql_insert_customer = "INSERT INTO customer (username, first_name, last_name, passport_id, region, tel, email) VALUES ('$username', '$firstname', '$lastname', '$passportid', '$region', '$tel', '$email')";
            $query_result_account = $conn->query($sql_insert_account);
            $query_result_customer = $conn->query($sql_insert_customer);

            // check if insert successfully
            if($query_result_account === true) {
                $response["status"] = "success";
            }
            else {
                $response["status"] = "fail";
            }
        }
        // returned type is json
        echo json_encode($response);

        // close connection to database
        $conn->close();
    }
?>