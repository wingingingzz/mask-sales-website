<!--
    File name: salesrep.php
    Functionality: interface for salesrep to view all orders that belong to him/her,
            to delete anomaly orders within 24 hours
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
-->

<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<!--to accommodate different devices-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>mask store</title>
        <!--bootstrap-->
		<link rel="stylesheet" type="text/css" href="../../published/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/navigation.css">
	</head>
	<body>
		<div class="container">
            <header class="header">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="header-content d-flex flex-row align-items-center justify-content-start">
								<div class="logo"><a>Woolin Auto</a></div>
								<nav class="my-nav">
									<ul>
                                        <li><a href="salesrep.php">Orders</a></li>
                                        <li><a href="view_quota.php">Info</a></li>
										<li><a href="contact_manager.html" onclick="return false;">Contact manager</a></li>
										<li><a href="contact_customer.php" onclick="return false;">Contact customers</a></li>
										<li><input class="button" id="logout" type="button" value="Login/Logout"></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>
			
			<br><br><br><br><br><br>
			<div id="content">
                <h1 align="center">View all orders</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>mask type</th>
                            <th>quantity</th>
                            <th>sales amount</th>
                            <th>order time</th>
                            <th>status</th>
                            <th>customer username</th>
                            <th>telephone</th>
                            <th>email</th>
                        </tr>
                    </thead>
                    <?php
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

                            // select orders that belongs to the salesrep who has logged in
                            $sql_select_orders = "SELECT * FROM ordering, salesrep WHERE salesrep_employee_id = employee_id AND username = '$username'";
                            $query_result_orders = $conn->query($sql_select_orders);
                            $nrow = $query_result_orders->num_rows;

                            // check if the salesrep has any order.
                            if ($nrow === 0) {
                                echo "<p>You haven't had any orders from customers.</p>";
                            }
                            else { // print orders that belong to the salesrep to the table
                                while ($row = $query_result_orders->fetch_assoc()) {

                                    // get customer info (tel and email) and print to table
                                    $customer_username = $row["customer_username"];
                                    $sql_select_customer = "SELECT tel, email FROM customer WHERE username = '$customer_username'";
                                    $query_result_customer = $conn->query($sql_select_customer);
                                    $row_customer = $query_result_customer->fetch_assoc();
                                    echo "<tr><td>".$row["ordering_id"]."</td><td>".$row["mask_type"]."</td><td>".$row["quantity"]."</td><td>".$row["sales_amount"]."</td><td>".$row["creation_time"]."</td><td>".$row["status"]."</td><td>".$row["customer_username"]."</td><td>".$row_customer["tel"]."</td><td>".$row_customer["email"]."</td><tr>";
                                }
                            }
                        }
                        else { // if user haven't logged in, alert user.
                            echo "<p>You haven't logged in.</p>";
                        }
                    ?>
                </table>
                <br><HR><br>
                <h1 align="center">View anomaly orders within 24 hours</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>mask type</th>
                            <th>quantity</th>
                            <th>sales amount</th>
                            <th>order time</th>
                            <th>status</th>
                            <th>customer username</th>
                            <th>telephone</th>
                            <th>email</th>
                        </tr>
                    </thead>
                    <?php
                        // check if user has logged in
                        if(isset($_SESSION["username"]) === true) {
                            $username = $_SESSION["username"];

                            // select all anomaly orders
                            $sql_select_anomaly = "SELECT * FROM ordering, salesrep 
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
                                        $count_delete = $count_delete + 1;
                                        echo "<tr><td>".$row["ordering_id"]."</td><td>".$row["mask_type"]."</td><td>".$row["quantity"]."</td><td>".$row["sales_amount"]."</td><td>".$row["creation_time"]."</td><td>".$row["status"]."</td><td>".$row["customer_username"]."</td><td>".$row_customer["tel"]."</td><td>".$row_customer["email"]."</td><tr>";
                                    }
                                }
                                // count the number of anomaly orders
                                if ($count_delete === 0) {
                                    echo "<p>No anomaly records that can be deleted.</p>";
                                }
                            }
                            else {
                                echo "<p>No anomaly records that can be deleted.</p>";
                            }
                            // close connetion to database
                            $conn->close();
                        }
                        else { // if user haven't logged in, alert user.
                            echo "<p>You haven't logged in.</p>";
                        }
                    ?>
                </table><br>
				<div id="message-area"></div>
				<input class="button" id="delete-anomaly-button" name="delete-anomaly-button" type="button" value="Delete anomaly orders">
			</div>
        </div>
        <br><br>
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="salesrep.js"></script>
		<script src="logout.js"></script>
	</body>
</html>