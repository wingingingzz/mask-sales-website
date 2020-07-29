<!--
    File name: customer_orders.php
    Functionality: interface for customer to view all orders that belong to him/her
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
										<li><a href="customer.php">Home Page</a></li>
										<li><a href="user_center.html">User Center</a></li>
										<li><a href="customer_orders.php">Orders</a></li>
										<li><a href="contact_salesrep.html" onclick="return false;">Contact</a></li>
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
                <div class="row clearfix">
                    <div class="col-md-12 column">
                        <h1 align="center">View all orders</h1><br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ordering id</th>
                                    <th>mask type</th>
                                    <th>quantity</th>
                                    <th>sales amount</th>
                                    <th>order time</th>
                                    <th>status</th>
                                    <th>salesrep username</th>
                                    <th>telephone</th>
                                    <th>email</th>
                                </tr>
                            </thead>
                            <?php
                                // start session
                                session_start();

                                // check if user has logged in
                                if (isset($_SESSION["username"]) === true) {
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

                                    // select all orders without anomalies that belong to this customer
                                    $sql_select_orders = "SELECT * FROM ordering, salesrep WHERE customer_username = '$username' AND salesrep_employee_id = employee_id ORDER BY ordering_id";
                                    $query_result_orders = $conn->query($sql_select_orders);
                                    $nrow = $query_result_orders->num_rows;
                                    if ($nrow > 0) {
                                        while ($row = $query_result_orders->fetch_assoc()) {
                                            echo "<tr><td>".$row['ordering_id']."</td><td>".$row['mask_type']."</td><td>".$row['quantity']."</td><td>".$row['sales_amount']."</td><td>".$row['creation_time']."</td><td>".$row['status']."</td><td>".$row['username']."</td><td>".$row['tel']."</td><td>".$row['email']."</td></td>";;
                                        }
                                    }
                                    else {
                                        echo "<p>No such record to be deleted.</p>";
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
                <br><HR><br>
                <div class="row clearfix">
					<div class="col-md-12 column">
                        <h1 align="center">Delete your order within 24 hours</h1><br>
						<form role="form">
                            <div class="form-group">
								<label for="delete-id">Ordering ID</label>
                                <input class="form-control" id="delete-id" name="delete-id" type="text" placeholder="Please enter the ordering ID of order you want to delete.">
                                <div id="validation-delete-id"></div>
							</div><br>
                            <div class="form-group">
								<div id="message-area"></div>
								<input class="button" id="delete-botton" name="delete-botton" type="button" value="Delete">
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!--validation-->
		<script src="../my_validation.js"></script>
		<script src="delete_order.js"></script>
		<script src="logout.js"></script>
	</body>
</html>