<?php
    // File name: delete_order.php
    // Functionality: implement server-side validation and request of deleting any order within 24 hours
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);
    $request = $param_obj->request;
    $delete_id = $param_obj->delete_id;

    $response = array();

    // ensure request is to delete chosen order
    if ($request == "delete_order") {
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

            // select order chosen to be deleted
            $sql_select_order = "SELECT creation_time, salesrep_employee_id, quantity FROM ordering
                    WHERE ordering_id = '$delete_id' AND customer_username = '$username'";
            $query_result_order = $conn->query($sql_select_order);
            $nrow = $query_result_order->num_rows;
            if ($nrow > 0) {
                $row = $query_result_order->fetch_assoc();
                $employee_id = $row['salesrep_employee_id'];
                $quantity = $row['quantity'];

                // check if the order is within 24 hours
                ini_set('date.timezone','Asia/Shanghai');
                $current_time = date("Y-m-d H:i:s");
                $creation_time = $row['creation_time'];
                $time_difference = strtotime($current_time) - strtotime($creation_time); // unit: sec
                if($time_difference > 86400){ // 60s*60min*24h
                    $response["status"] = "timeover";
                }
                else {
                    // delete the order if it's within 24 hours
                    $sql_delete_order = "DELETE FROM ordering WHERE ordering_id = '$delete_id'";
                    $query_result_delete = $conn->query($sql_delete_order);
                    if ($query_result_delete === true) {
                        $response["status"] = "success";

                        // update salesrep's quota
                        $sql_change_quota = "UPDATE salesrep SET quota = quota + '$quantity' WHERE employee_id = '$employee_id'";
                        $conn->query($sql_change_quota);
                    }
                    else {
                        $response["status"] = "fail";
                    }
                }
            }
            else { // if there is no record in table that matches the ordering id
                $response["status"] = "no_record";
            }
            // close connection to database
            $conn->close();
        }
        else {
            $response["status"] = "no_login";
        }
    }
    // returned type is json
    echo json_encode($response);
?>