<!--
    File name: sta_salesrep.php
    Functionality: interface for manager to view statistics of salesreps
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
                <h1 align="center">View statistics of salesreps</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>salesrep employee id</th>
                            <th>username</th>
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

                            // This method can only display salesreps who have orders
                            // $sql_group_salesrep = "SELECT salesrep_employee_id, SUM(quantity) AS sum_salesrep_quantity, SUM(sales_amount) AS sum_salesrep_amount FROM ordering
                            //         WHERE status = 'N' GROUP BY salesrep_employee_id ORDER BY salesrep_employee_id";
                            // $query_result_salesrep = $conn->query($sql_group_salesrep);
                            // $nrow_salesrep = $query_result_salesrep->num_rows;
                            // if ($nrow_salesrep === 0) {
                            //     echo "No records.";
                            // }
                            // else {
                            //     while ($row = $query_result_salesrep->fetch_assoc()) {
                            //         echo "<tr><td>".$row['salesrep_employee_id']."</td><td>".$row['sum_salesrep_quantity']."</td><td>".$row['sum_salesrep_amount']."</td><tr>";
                            //     }
                            // }

                            // select all salesreps from database
                            $sql_select_salesrep = "SELECT employee_id, username FROM salesrep ORDER BY employee_id";
                            $query_result_salesrep = $conn->query($sql_select_salesrep);
                            $nrow = $query_result_salesrep->num_rows;

                            // check if there's any salesrep
                            if ($nrow > 0) {
                                while ($row = $query_result_salesrep->fetch_assoc()) {
                                    $employee_id = $row["employee_id"];
                                    $username = $row["username"];

                                    // calculate sum of quantity and sales amount of orders that belong to this salesrep
                                    $sql_select_order = "SELECT SUM(quantity) AS salesrep_sum_quantity, 
                                            SUM(sales_amount) AS salesrep_sum_amount FROM ordering 
                                            WHERE salesrep_employee_id = $employee_id AND status = 'N'";
                                    $query_result_order = $conn->query($sql_select_order);
                                    $row_order = $query_result_order->fetch_assoc();

                                    // replace null by 0 if no order belongs to this salesrep
                                    if ($row_order['salesrep_sum_quantity'] === null) {
                                        $salesrep_sum_quantity = 0;
                                        $salesrep_sum_amount = 0;
                                    }
                                    else {
                                        $salesrep_sum_quantity = $row_order['salesrep_sum_quantity'];
                                        $salesrep_sum_amount = $row_order['salesrep_sum_amount'];
                                    }

                                    // display the results in the table
                                    echo "<tr><td>".$employee_id."</td><td>".$username."</td><td>".$salesrep_sum_quantity."</td><td>".$salesrep_sum_amount."</td><tr>";
                                }
                            }
                            else {
                                echo "<p>No records.</p>";
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