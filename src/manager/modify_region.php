<?php
    // File name: modify_region.php
    // Functionality: implement request of assigning a chosen salesrep to a region for customer
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);
    $request = $param_obj->request;
    $employee_id = $param_obj->employee_id;
    $region = $param_obj->region;

    $response = array();

    // ensure request is to modify region of salesrep chosen by manager
    if ($request == "modify_region") {
        // start session
        session_start();

        // check if user has logged in
        if(isset($_SESSION["username"]) === true && $_SESSION["username"] === "manager") {
            // connect to database
            $db_servername = "localhost";
            $db_username = "scyqw4";
            $db_password = "scyqw4";
            $db_dbname = "scyqw4";
 
            $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
            if ($conn->connect_error) {
                die("Connection failed: ".$conn->connect_error);
            }

            // select salesrep chosen by manager from database
            $sql_check_salesrep = "SELECT employee_id FROM salesrep WHERE employee_id = '$employee_id'";
            $sql_result_salesrep = $conn->query($sql_check_salesrep);
            $nrow = $sql_result_salesrep->num_rows;

            // check if salesrep chosen by manager exists or not
            if ($nrow > 0) {

                // update the region of salesrep chosen by manager if salesrep exists
                $sql_update_region = "UPDATE salesrep SET region = '$region' WHERE employee_id = '$employee_id'";

                // check if update successfully
                if ($conn->query($sql_update_region) === true) {
                    $response["status"] = "success";
                }
                else {
                    $response["status"] = "fail";
                }
            }
            else {
                $response["status"] = "no_salesrep";
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