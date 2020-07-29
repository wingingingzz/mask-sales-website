<!--
    File name: sta_region.php
    Functionality: interface for manager to view statistics of region
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
                <h1 align="center">View statistics of regions</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>region</th>
                            <th>sum of masks sold</th>
                            <th>sum of sales amount</th>
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

                            // this method can only display regions that have orders, but not all regions
                            // $sql_group_region = "SELECT region, SUM(quantity) AS sum_region_quantity, SUM(sales_amount) AS sum_region_amount FROM ordering, customer 
                            //         WHERE ordering.customer_username = customer.username AND ordering.status = 'N' GROUP BY region";
                            // $query_result_region = $conn->query($sql_group_region);
                            // $nrow_region = $query_result_region->num_rows;
                            // if ($nrow_region > 0) {
                            //     while ($row = $query_result_region->fetch_assoc()) {
                            //         echo "<tr><td>".$row['region']."</td><td>".$row['sum_region_quantity']."</td><td>".$row['sum_region_amount']."</td><tr>";
                            //     }
                            // }
                            // else {
                            //     echo "No records.";
                            // }

                            // select orders of each region
                            $sql_select_china = "SELECT SUM(quantity) AS china_sum_quantity, SUM(sales_amount) AS china_sum_amount FROM ordering, customer
                                    WHERE ordering.customer_username = customer.username AND ordering.status = 'N' AND customer.region = 'China'";
                            $sql_select_thailand = "SELECT SUM(quantity) AS thailand_sum_quantity, SUM(sales_amount) AS thailand_sum_amount FROM ordering, customer
                                    WHERE ordering.customer_username = customer.username AND ordering.status = 'N' AND customer.region = 'Thailand'";
                            $sql_select_uk = "SELECT SUM(quantity) AS uk_sum_quantity, SUM(sales_amount) AS uk_sum_amount FROM ordering, customer
                                    WHERE ordering.customer_username = customer.username AND ordering.status = 'N' AND customer.region = 'UK'";
                            $sql_select_korea = "SELECT SUM(quantity) AS korea_sum_quantity, SUM(sales_amount) AS korea_sum_amount FROM ordering, customer
                                    WHERE ordering.customer_username = customer.username AND ordering.status = 'N' AND customer.region = 'Korea'";
                            
                            $query_result_china = $conn->query($sql_select_china);
                            $row = $query_result_china->fetch_assoc();

                            // replace null by 0 if there's no order in China
                            if ($row['china_sum_quantity'] === null) {
                                echo "<tr><td>"."China"."</td><td>"."0"."</td><td>"."0"."</td><tr>";
                            }
                            else {
                                echo "<tr><td>"."China"."</td><td>".$row['china_sum_quantity']."</td><td>".$row['china_sum_amount']."</td><tr>";
                            }

                            $query_result_thailand = $conn->query($sql_select_thailand);
                            $row = $query_result_thailand->fetch_assoc();

                            // replace null by 0 if there's no order in the Thailand
                            if ($row['thailand_sum_quantity'] === null) {
                                echo "<tr><td>"."Thailand"."</td><td>"."0"."</td><td>"."0"."</td><tr>";
                            }
                            else {
                                echo "<tr><td>"."Thailand"."</td><td>".$row['thailand_sum_quantity']."</td><td>".$row['thailand_sum_amount']."</td><tr>";
                            }

                            $query_result_uk = $conn->query($sql_select_uk);
                            $row = $query_result_uk->fetch_assoc();

                            // replace null by 0 if there's no order in the UK
                            if ($row['uk_sum_quantity'] === null) {
                                echo "<tr><td>"."UK"."</td><td>"."0"."</td><td>"."0"."</td><tr>";
                            }
                            else {
                                echo "<tr><td>"."UK"."</td><td>".$row['uk_sum_quantity']."</td><td>".$row['uk_sum_amount']."</td><tr>";
                            }

                            $query_result_korea = $conn->query($sql_select_korea);
                            $row = $query_result_korea->fetch_assoc();

                            // replace null by 0 if there's no order in the Korea
                            if ($row['korea_sum_quantity'] === null) {
                                echo "<tr><td>"."Korea"."</td><td>"."0"."</td><td>"."0"."</td><tr>";
                            }
                            else {
                                echo "<tr><td>"."Korea"."</td><td>".$row['korea_sum_quantity']."</td><td>".$row['korea_sum_amount']."</td><tr>";
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
    </body>
</html>