<?php
    // File name: delete_anomaly.php
    // Functionality: implement server-side validation and request of deleting orders with anomalies within 24 hours for salesrep
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

    // ensure request is to delete anomaly orders within 24 hours
    if ($request === "delete_anomaly") {

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

            // select all anomaly orders
            $sql_select_anomaly = "SELECT ordering_id, creation_time, quantity FROM ordering, salesrep 
                    WHERE username = '$username' AND salesrep_employee_id = employee_id AND status = 'A'";
            $query_result_anomaly = $conn->query($sql_select_anomaly);
            $nrow = $query_result_anomaly->num_rows;

            // check if anomaly orders exist
            if ($nrow > 0) {
                $count_delete = 0;
                $count_quantity = 0;
                while ($row = $query_result_anomaly->fetch_assoc()) {
                    $ordering_id = $row['ordering_id'];

                    ini_set('date.timezone','Asia/Shanghai');
                    $current_time = strtotime(date("Y-m-d H:i:s"));
                    $creation_time = strtotime($row['creation_time']);

                    // check if the anomaly order is within 24 hours
                    if($current_time - $creation_time > 86400){ // 60s*60min*24h
                        continue;
                    }
                    else {
                        // delete the anomaly order that are within 24 hours
                        $sql_delete_anomaly = "DELETE FROM ordering WHERE ordering_id = '$ordering_id'";
                        $query_result_delete = $conn->query($sql_delete_anomaly);
                        $count_delete = $count_delete + 1;

                        $count_quantity = $count_quantity + $row['quantity'];
                    }
                }
                // count the number of anomaly orders
                if ($count_delete === 0) {
                    $response["status"] = "no_record";
                }
                else {
                    $response["status"] = "success";
                    $response["delete_no"] = $count_delete;

                    // update salesrep's quota
                    $sql_update_quota = "UPDATE salesrep SET quota = quota + '$count_quantity' WHERE username = '$username'";
                    $conn->query($sql_update_quota);
                }
            }
            else {
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