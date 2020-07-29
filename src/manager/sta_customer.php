<!--
    File name: sta_customer.php
    Functionality: interface for manager to view statistics of customers
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
                <h1 align="center">View statistics of customers</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>customer username</th>
                            <th>sum of masks sold</th>
                            <th>sum of sales amount</th>
                            <th>average of masks sold</th>
                            <th>average of sales amount</th>
                            <th>count of orders</th>
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

                            // this method can only display customers who have orders, but not all customers
                            // $sql_group_customer = "SELECT customer_username, SUM(quantity) AS sum_customer_quantity, SUM(sales_amount) AS sum_customer_amount, 
                            //         FORMAT(AVG(quantity),2) AS avg_customer_quantity, FORMAT(AVG(sales_amount),2) AS avg_customer_amount, COUNT(*) AS count_orders FROM ordering
                            //         WHERE ordering.status = 'N' GROUP BY customer_username";
                            // $query_result_customer = $conn->query($sql_group_customer);
                            // $nrow_customer = $query_result_customer->num_rows;
                            // if ($nrow_customer > 0) {
                            //     while ($row = $query_result_customer->fetch_assoc()) {
                            //         echo "<tr><td>".$row['customer_username']."</td><td>".$row['sum_customer_quantity']."</td><td>".$row['sum_customer_amount']."</td><td>".$row['avg_customer_quantity']."</td><td>".$row['avg_customer_amount']."</td><td>".$row['count_orders']."</td><tr>";
                            //     }
                            // }
                            // else {
                            //     echo "No records.";
                            // }

                            // select all customers' username
                            $sql_select_customer = "SELECT username FROM customer ORDER BY username";
                            $query_result_customer = $conn->query($sql_select_customer);
                            $nrow_customer = $query_result_customer->num_rows;

                            // check if there's any customer
                            if ($nrow_customer > 0) {
                                while ($row_customer = $query_result_customer->fetch_assoc()) {
                                    $username = $row_customer['username'];

                                    // calculate the sum/avg of quantity and salesrep and count of orders that are placed by this customer
                                    $sql_select_order = "SELECT SUM(quantity) AS customer_sum_quantity, SUM(sales_amount) AS customer_sum_amount, 
                                            FORMAT(AVG(quantity),2) AS customer_avg_quantity, FORMAT(AVG(sales_amount),2) AS customer_avg_amount, 
                                            COUNT(*) AS customer_count FROM ordering WHERE status = 'N' AND customer_username = '$username'";
                                    $query_result_order = $conn->query($sql_select_order);
                                    $row_order = $query_result_order->fetch_assoc();

                                    // replace null by 0 if the customer has no order
                                    if ($row_order['customer_sum_quantity'] === null) {
                                        $customer_sum_quantity = 0;
                                        $customer_sum_amount = 0;
                                        $customer_avg_quantity = 0;
                                        $customer_avg_amount = 0;
                                        $customer_count = 0;
                                    }
                                    else {
                                        $customer_sum_quantity = $row_order['customer_sum_quantity'];
                                        $customer_sum_amount = $row_order['customer_sum_amount'];
                                        $customer_avg_quantity = $row_order['customer_avg_quantity'];
                                        $customer_avg_amount = $row_order['customer_avg_amount'];
                                        $customer_count = $row_order['customer_count'];
                                    }

                                    // display the result in the table
                                    echo "<tr><td>".$username."</td><td>".$customer_sum_quantity."</td><td>".$customer_sum_amount."</td><td>".$customer_avg_quantity."</td><td>".$customer_avg_amount."</td><td>".$customer_count."</td><tr>";
                                }
                            }
                            else {
                                echo "<p>No records.</p>";
                            }
                        }
                        else {
                            echo "<p>You haven't logged in.</p>";
                        }
                    ?>
                </table>
                <div>
                    <p>Total no. of customers who have orders:&nbsp;&nbsp;
                    <?php
                        // check if user has logged in
                        if(isset($_SESSION["username"]) === true && $_SESSION["username"] === "manager") {

                            // calculate total number of customer
                            $sql_count_customers = "SELECT COUNT(*) AS count_customers FROM ordering GROUP BY customer_username";
                            $query_result_customers = $conn->query($sql_count_customers);
                            $row = $query_result_customers->fetch_assoc();

                            // replace null by 0 if there's no customer
                            if ($row['count_customers'] === null) {
                                $count_customers = 0;
                            }
                            else {
                                $count_customers = $row['count_customers'];
                            }
                            echo $count_customers;
                        }
                    ?>
                    </p>
                </div>
                <div>
                    <p>Total no. of customers:&nbsp;&nbsp;
                    <?php
                        // check if user has logged in
                        if(isset($_SESSION["username"]) === true && $_SESSION["username"] === "manager") {

                            // calculate total number of customer
                            $sql_count_customers = "SELECT COUNT(*) AS count_customers FROM customer";
                            $query_result_customers = $conn->query($sql_count_customers);
                            $row = $query_result_customers->fetch_assoc();

                            // replace null by 0 if there's no customer
                            if ($row['count_customers'] === null) {
                                $count_customers = 0;
                            }
                            else {
                                $count_customers = $row['count_customers'];
                            }
                            echo $count_customers;

                            // close connection to database
                            $conn->close();
                        }
                    ?>
                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>