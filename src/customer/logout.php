<?php
    // File name: logout.php
    // Functionality: implement logout request
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

    // check if request is to logout
    if ($request === "logout") {
        // start session
        session_start();

        // check if user has logged in
        if(isset($_SESSION["username"]) === true) {
            session_unset(); // clear the session
            $response['status'] = "success";
        }
        else {
            $response['status'] = "no_login";
        }
    }
    // returned type is json
    echo json_encode($response);
?>