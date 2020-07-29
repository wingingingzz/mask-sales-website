<!--
    File name: customer.php
    Functionality: interface for manager to view information of all customers
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
				<div class="header_container">
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
				</div>
			</header>

            <br><br><br><br><br><br>
            <div id="content">
                <h1 align="center">View all customers</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>customer username</th>
                            <th>first name</th>
                            <th>last name</th>
                            <th>passport id</th>
                            <th>region</th>
                            <th>telephone</th>
                            <th>email</th>
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

                            // select all customers' info from database and display all in the table
                            $sql_select_customer = "SELECT * FROM customer";
                            $query_result_customer = $conn->query($sql_select_customer);

                            // check if there's any customer in the database
                            $nrow = $query_result_customer->num_rows;
                            if ($nrow === 0) {
                                echo "<p>No customers.</p>";
                            }
                            else {
                                while ($row = $query_result_customer->fetch_assoc()) {
                                    echo "<tr><td>".$row["username"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["passport_id"]."</td><td>".$row["region"]."</td><td>".$row["tel"]."</td><td>".$row["email"]."</td><tr>";
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