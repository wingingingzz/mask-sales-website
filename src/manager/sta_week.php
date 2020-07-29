<!--
    File name: sta_region.php
    Functionality: interface for manager to view statistics within 1 week
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
                                        <li><a href="sta_total.php">Total</a></li>
                                        <li><a href="sta_salesrep.php">Salesrep</a></li>
                                        <li><a href="sta_region.php">Region</a></li>
                                        <li><a href="sta_under_ordering.php">Under ordering</a></li>
                                        <li><a href="sta_week.php">Week</a></li>
                                        <li><a href="sta_customer.php">Customer</a></li>
										<li><a href="statistics.html">Back</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>

            <br><br><br><br><br><br>
			<div id="content">
                <h1 align="center">View statistics within 1 week</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>sum of masks sold</th>
                            <th>sum of sales amount</th>
                            <th>average of masks sold per order</th>
                            <th>average of sales amount per order</th>
                            <th>count of normal orders</th>
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

                            // select some info of normal orders
                            $sql_select_orders = "SELECT quantity, sales_amount, creation_time FROM ordering WHERE status = 'N'";
                            $query_result_orders = $conn->query($sql_select_orders);
                            $nrow = $query_result_orders->num_rows;

                            // check if there's any normal orders
                            if ($nrow === 0) {
                                echo "<p>No masks within 1 week.</p>";
                            }
                            else {
                                $count_orders = 0; // count orders within 1 week
                                $sum_quantity = 0; // sum of quantity of orders within 1 week
                                $sum_salesamount = 0; // sum of sales amount of orders within 1 week
                                while ($row = $query_result_orders->fetch_assoc()) {

                                    // set time zone
                                    ini_set('date.timezone','Asia/Shanghai');
                                    $current_time = strtotime(date("Y-m-d H:i:s"));
                                    $creation_time = strtotime($row['creation_time']);

                                    // check if the normal order is within 1 week
                                    if ($current_time - $creation_time < 604800) { // 7days * 24hrs * 60mins * 60mins
                                        $count_orders = $count_orders + 1;
                                        $sum_quantity = $sum_quantity + $row['quantity'];
                                        $sum_salesamount = $sum_salesamount + $row['sales_amount'];
                                    }
                                    else {
                                        continue;
                                    }
                                }
                                // check if there's any normal order is within 1 week
                                if ($count_orders === 0) {
                                    echo "<p>No masks under ordering.</p>";
                                }
                                else {
                                    // calculate avg of quantity and sales amount of normal orders within 1 week
                                    $avg_quantity = $sum_quantity/$count_orders;
                                    $avg_salesamount = $sum_salesamount/$count_orders;

                                    // display the results in the table
                                    echo "<tr><td>".$sum_quantity."</td><td>".$sum_salesamount."</td><td>".$avg_quantity."</td><td>".$avg_salesamount."</td><td>".$count_orders."</td><tr>";
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
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="logout.js"></script>
	</body>
</html>