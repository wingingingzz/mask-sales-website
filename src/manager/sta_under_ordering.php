<!--
    File name: sta_region.php
    Functionality: interface for manager to view masks under ordering
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
                <h1 align="center">View masks under ordering</h1><br>
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

                            // select all normal orders from database
                            $sql_select_under_ordering = "SELECT * FROM ordering WHERE status = 'N'";
                            $query_result_under_ordering = $conn->query($sql_select_under_ordering);
                            $nrow = $query_result_under_ordering->num_rows;

                            // check if there's any normal order
                            if ($nrow === 0) {
                                echo "<p>No masks under ordering.</p>";
                            }
                            else {
                                $count_under_ordering = 0; // count orders under ordering (normal orders within 24 hours)
                                while ($row = $query_result_under_ordering->fetch_assoc()) {
                                    // set time zone
                                    ini_set('date.timezone','Asia/Shanghai');
                                    $current_time = strtotime(date("Y-m-d H:i:s"));
                                    $creation_time = strtotime($row['creation_time']);

                                    // check if the normal order is within 24 hours (under ordering)
                                    if ($current_time - $creation_time < 86400) {
                                        echo "<tr><td>".$row["ordering_id"]."</td><td>".$row["mask_type"]."</td><td>".$row["quantity"]."</td><td>".$row["sales_amount"]."</td><td>".$row["creation_time"]."</td><td>".$row["status"]."</td><td>".$row["customer_username"]."</td><td>".$row["salesrep_employee_id"]."</td><tr>";
                                        $count_under_ordering = $count_under_ordering + 1;
                                    }
                                    else {
                                        continue;
                                    }
                                }
                                // check if there's any order under ordering
                                if ($count_under_ordering === 0) {
                                    echo "<p>No masks under ordering.</p>";
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