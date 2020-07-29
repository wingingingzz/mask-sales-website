<?php
    // File name: modify_info.php
    // Functionality: implement server-side validation and request of updating/modifying information of customer
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);
    $request = $param_obj->request;
    $password = $param_obj->password;
    $firstname = $param_obj->firstname;
    $lastname = $param_obj->lastname;
    $passportid = $param_obj->passportid;
    $region = $param_obj->region;
    $tel = $param_obj->tel;
    $email = $param_obj->email;
    $user_type = "customer";

    $response = array();

    // ensure request is to modify customer info
    if ($request === "modify_info") {
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

            // update customer's info
            $sql_modify_password = "UPDATE account SET password = '$password' WHERE username = '$username'";
            $sql_modify_info = "UPDATE customer SET first_name = '$firstname', last_name = '$lastname',
                    passport_id = '$passportid', region = '$region', tel = '$tel', email = '$email'
                    WHERE username = '$username'";
            $query_result_password = $conn->query($sql_modify_password);
            $query_result_info = $conn->query($sql_modify_info);

            // check if update successfully
            if ($query_result_password === true && $query_result_info === true) {
                $response["status"] = "success";
            }
            else {
                $response["status"] = "fail";
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