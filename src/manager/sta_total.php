<!--
    File name: sta_region.php
    Functionality: interface for manager to view statistics of total
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
                <h1 align="center">View statistics of total</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>total no. of masks sold (w/o anomalies)</th>
                            <th>total no. of masks sold (w/ anomalies)</th>
                            <th>total revenues</th>
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

                            // calculate sum of quantity and sales amount of all normal orders
                            $sql_sum_woanomaly = "SELECT SUM(quantity) AS sum_woanomaly, SUM(sales_amount) AS total_revenues 
                                    FROM ordering WHERE status = 'N'";
                            $query_result_sum_woanomaly = $conn->query($sql_sum_woanomaly);
                            $row_woanomaly = $query_result_sum_woanomaly->fetch_assoc();

                            // replace null by 0 if there's no normal order
                            if ($row_woanomaly["sum_woanomaly"] === null) {
                                $sum_woanomaly = 0;
                                $total_revenues = 0;
                            }
                            else {
                                $sum_woanomaly = $row_woanomaly["sum_woanomaly"];
                                $total_revenues = $row_woanomaly["total_revenues"];
                            }

                            // calculate sum of quantity of all anomaly orders
                            $sql_sum_wanomaly = "SELECT SUM(quantity) AS sum_wanomaly FROM ordering WHERE status = 'A'";
                            $query_result_sum_wanomaly = $conn->query($sql_sum_wanomaly);
                            $row_wanomaly = $query_result_sum_wanomaly->fetch_assoc();

                            // replace null by 0 if there's no anomaly order
                            if ($row_wanomaly["sum_wanomaly"] === null) {
                                $sum_wanomaly = 0;
                            }
                            else {
                                $sum_wanomaly = $row_wanomaly["sum_wanomaly"];
                            }
                            // display the results in the table
                            echo "<tr><td>".$sum_woanomaly."</td><td>".$sum_wanomaly."</td><td>".$total_revenues."</td><tr>";

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
    </body>
</html>