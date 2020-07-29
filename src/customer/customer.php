<!--
    File name: customer.php
    Functionality: interface for customer to view information of masks and order masks.
    Author: Qingyu WANG
    Copyright [2020-05-26] by [Qingyu WANG] [Woolin Auto SMS]
    All rights reserved.
-->

<!DOCTYPE html>
<html>
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
				<h1 align="center">Product introduction</h1><br>
				<div class="row clearfix">
					<div class="col-md-4 column">
							<img alt="140x140" src="image/N95.jpg">
						<h4>N95 respirators</h4><br>
						<p><b>
                            <?php
                                // start session
                                session_start();
								
								// connect to database
                                $db_servername = "localhost";
								$db_username = "scyqw4";
								$db_password = "scyqw4";
								$db_dbname = "scyqw4";

                                $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
                                if ($conn->connect_error) {
                                    die("Connection failed: ".$conn->connect_error);
                                }

								// get unit price of N95 from database
                                $sql_N95_price = "SELECT unit_price FROM mask WHERE mask_type = 'N95'";
                                $query_result_N95 = $conn->query($sql_N95_price);
                                $row = $query_result_N95->fetch_assoc();

                                echo $row['unit_price']." RMB";
                            ?>
                        </b></p>
						<p>
							<b>Suitable for:</b><br>
							Field investigation and sampling personnel; highly crowded or confined spaces.
						</p>
					</div>
					<div class="col-md-4 column">
							<img alt="140x140" src="image/surgical.jpg">
						<h4>surgical masks</h4><br>
						<p><b>
                            <?php
								// get unit price of S from database
                                $sql_S_price = "SELECT unit_price FROM mask WHERE mask_type = 'S'";
                                $query_result_S = $conn->query($sql_S_price);
                                $row = $query_result_S->fetch_assoc();

                                echo $row['unit_price']." RMB";
                            ?>
                        </b></p>
						<p>
							<b>Suitable for:</b> <br>
							Suspected cases; public transport agents, taxi driver, sanitationman, service personnel in public places, etc. during working hours.
						</p>
					</div>
					<div class="col-md-4 column">
							<img alt="140x140" src="image/surgicalN95.png">
						<h4>surgical N95 respirators</h4><br>
						<p><b>
                            <?php
								// get unit price of SN95
                                $sql_SN95_price = "SELECT unit_price FROM mask WHERE mask_type = 'SN95'";
                                $query_result_SN95 = $conn->query($sql_SN95_price);
                                $row = $query_result_SN95->fetch_assoc();

                                echo $row['unit_price']." RMB";
                            ?>
                    	</b></p>
						<p>
							<b>Suitable for:</b> <br>
							Medical staff in fever clinics and isolation wards; patients with confirmed.
						</p>
                    </div>
				</div>
				<br><HR><br>
				<div class="row clearfix">
					<div class="col-md-12 column">
						<h1 align="center">Order product</h1><br>
						<form role="form">
							<div class="form-group">
								<label for="mask-type">Mask Type</label><br>
								<select class="button selectpicker" id="mask-type" name="mask-type">
									<option value="N95">N95 respirators</option>
									<option value="S">surgical masks</option>
									<option value="SN95">surgical N95</option>
								</select>
							</div>
							<div class="form-group">
								<label for="quantity">Quantity</label>
								<input class="form-control" id="quantity" name="quantity" type="text">
								<div id="validation-quantity"></div>
							</div>
							<div class="form-group">
								<label for="employee-id">Assign sales representative</label>
								<input class="form-control" id="employee-id" name="employee-id" type="text" placeholder="Please enter employee ID of salesrep you want to assign.">
								<div id="validation-employee-id"></div>
							</div><br>
							<div class="form-group">
								<div id="message-area"></div>
								<input class="button" id="order-botton" name="order-botton" type="button" value="Order">
							</div>
							<br><HR><br>
							<h1 align="center">View all salesreps you can assign</h1><br>
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">employee id</th>
										<th scope="col">username</th>
										<th scope="col">telephone</th>
										<th scope="col">email</th>
										<th scope="col">quota</th>
									</tr>
								</thead>
								<tbody>
									<?php
										// check if user has logged in
										if(isset($_SESSION["username"]) === true) {
											$username = $_SESSION["username"];

											// get customer's region
											$sql_check_region = "SELECT region FROM customer WHERE username = '$username'";
											$query_result_region = $conn->query($sql_check_region);
											$row = $query_result_region->fetch_assoc();
											$customer_region = $row['region'];

											// select all salesrep in the same region and display in the table
											$sql_select_salesrep = "SELECT * FROM salesrep WHERE region = '$customer_region' ORDER BY employee_id";
											$query_result_salesrep = $conn->query($sql_select_salesrep);
											$nrow = $query_result_salesrep->num_rows;

											// check if there're salesrep within same region
											if ($nrow > 0) {
												while ($row = $query_result_salesrep->fetch_assoc()) {
													echo "<tr><td>".$row['employee_id']."</td><td>".$row['username']."</td><td>".$row['tel']."</td><td>".$row['email']."</td><td>".$row['quota']."</td></td>";
												}
											}
											else {
												echo "<p>No sales representative in your region...</p>";
											}
										}
										else {
											echo "<p>You haven't logged in.</p>";
										}
										// close connection to database
										$conn->close();
									?>
								</tbody>
							</table>
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
		<script type="text/javascript" src="../my_validation.js"></script>
		<script type="text/javascript" src="home_page.js"></script>
		<script type="text/javascript" src="logout.js"></script>
	</body>
</html>