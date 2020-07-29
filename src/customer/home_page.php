<?php
    // File name: home_page.php
    // Functionality: implement server-side validation and request of mask ordering
    // Author: Qingyu WANG
    // Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    // All rights reserved.

    // necessary if returned type is json
    header('Content-Type:application/json;charset=utf-8');

    // get json data from client-side
    $param = file_get_contents("php://input");
    $param_obj = json_decode($param);

    $request = $param_obj->request;
    $mask_type = $param_obj->mask_type;
    $quantity = $param_obj->quantity;
    $employee_id = $param_obj->employee_id;

    $response = array();

    // ensure request is to order masks
    if ($request === "order") {
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

            // check if salesrep selected by customer exists or not
            // and if salesrep's region matches customer's region
            $sql_check_region = "SELECT quota FROM customer, salesrep WHERE customer.username = '$username'
                    AND salesrep.employee_id = '$employee_id' AND customer.region = salesrep.region";
            $query_result_region = $conn->query($sql_check_region);
            $nrow = $query_result_region->num_rows;
            if ($nrow > 0) {
                $row = $query_result_region->fetch_assoc();
                $salesrep_quota = $row['quota'];

                // check if quantity ordered by customer exceeds salesrep's quota
                if ($quantity > $salesrep_quota) {
                    $status = "A"; // with anomalies
                }
                else {
                    $status = "N"; // normal (without anomalies)
                }

                // get unit price of selected mask and calculate sales amount
                $sql_select_unitprice = "SELECT unit_price FROM mask WHERE mask_type = '$mask_type'";
                $query_result_unitprice = $conn->query($sql_select_unitprice);
                $row = $query_result_unitprice->fetch_assoc();
                $sales_amount = $row['unit_price'] * $quantity;

                // get current time
                ini_set('date.timezone','Asia/Shanghai');
                $creation_time = date("Y-m-d H:i:s");

                // insert the order into database
                $sql_insert_order = "INSERT INTO ordering (mask_type, quantity, sales_amount, creation_time, status, customer_username, salesrep_employee_id)
                        VALUES ('$mask_type', '$quantity', '$sales_amount', '$creation_time', '$status', '$username', '$employee_id')";
                if($conn->query($sql_insert_order) === true) {
                    $response["status"] = "success";
                    $response["sales_amount"] = $sales_amount;

                    // update salesrep's quota if insert successfully
                    $remain_quota = $salesrep_quota - $quantity;
                    $sql_update_quota = "UPDATE salesrep SET quota = '$remain_quota' WHERE employee_id = '$employee_id'";
                    $conn->query($sql_update_quota);
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