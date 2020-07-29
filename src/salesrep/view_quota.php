<!--
    File name: view_quota.php
    Functionality: interface for salesrep to view own personal information, including quota
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
                                        <li><a href="salesrep.php">Orders</a></li>
                                        <li><a href="view_quota.php">Info</a></li>
										<li><a href="contact_manager.html" onclick="return false;">Contact manager</a></li>
										<li><a href="contact_customer.php" onclick="return false;">Contact customers</a></li>
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
                <h1 align="center">View personal information</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>employee id</th>
                            <th>username</th>
                            <th>first name</th>
                            <th>last name</th>
                            <th>region</th>
                            <th>telephone</th>
                            <th>email</th>
                            <th>quota</th>
                        </tr>
                    </thead>
                    <?php
                        // start session
                        session_start();

                        // check if user has logged in
                        if(isset($_SESSION["username"]) === true) {             
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

                            // select orders that belongs to the salesrep who has logged in
                            $sql_select_quota = "SELECT * FROM salesrep WHERE username = '$username'";
                            $query_result_orders = $conn->query($sql_select_quota);
                            $row = $query_result_orders->fetch_assoc();
                            echo "<tr><td>".$row["employee_id"]."</td><td>".$row["username"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["region"]."</td><td>".$row["tel"]."</td><td>".$row["email"]."</td><td>".$row["quota"]."</td><tr>";

                            // close connection to database
                            $conn->close();
                        }
                        else { // if user haven't logged in, alert user.
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