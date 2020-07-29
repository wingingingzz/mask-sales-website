<!--
    File name: order.php
    Functionality: interface for manager to view all orders
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
        <title>manager</title>
        <!--bootstrap-->
		<link rel="stylesheet" type="text/css" href="../../published/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/navigation.css">
	</head>
	<body>
		<div class="container">
            <!--header-->
            <header class="header">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="header-content d-flex flex-row align-items-center justify-content-start">
								<div class="logo"><a>Woolin Auto</a></div>
								<nav class="my-nav">
									<ul>
                                        <li><a href="manager.php">Anomaly</a></li>
                                        <li><a href="order.php">Order</a></li>
                                        <li><a href="salesrep.html">Salesrep</a></li>
                                        <li><a href="customer.php">Customer</a></li>
                                        <li><a href="statistics.html">Statistics</a></li>
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
                <h1 align="center">View all orders</h1>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ordering id</th>
                            <th>mask type</th>
                            <th>quantity</th>
                            <th>sales amount</th>
                            <th>creation time</th>
                            <th>status</th>
                            <th>customer username</th>
                            <th>salesrep employee id</th>
                        </tr>
                    </thead>
                    <?php
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

                            // select all orders from database and display all in the table
                            $sql_select_order = "SELECT * FROM ordering";
                            $query_result_order = $conn->query($sql_select_order);
                            $nrow = $query_result_order->num_rows;

                            // check if there's any order
                            if ($nrow === 0) {
                                echo "<p>No orders.</p>";
                            }
                            else {
                                $count_order = 0; // count the number of orders
                                while ($row = $query_result_order->fetch_assoc()) {
                                    echo "<tr><td>".$row["ordering_id"]."</td><td>".$row["mask_type"]."</td><td>".$row["quantity"]."</td><td>".$row["sales_amount"]."</td><td>".$row["creation_time"]."</td><td>".$row["status"]."</td><td>".$row["customer_username"]."</td><td>".$row["salesrep_employee_id"]."</td><tr>";
                                    $count_order = $count_order + 1;
                                }
                                if ($count_order === 0) { // check if there's any order
                                    echo "<p>No orders.</p>";
                                }
                            }
                            // close connection to database
                            $conn->close();
                        }
                        else {
                            echo "<p>You haven't logged in.</p>";
                        }
                    ?>
                </table>
			</div>
        </div>
        <br><br>
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="logout.js"></script>
	</body>
</html>