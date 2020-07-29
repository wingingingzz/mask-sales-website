<!--
    File name: quota.php
    Functionality: interface for manager to re-grant/update quota of chosen salesrep
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
                                        <li><a href="assign_salesrep.html">Assign new salesrep</a></li>
                                        <li><a href="region.php">Modify region</a></li>
                                        <li><a href="quota.php">Modify quota</a></li>
                                        <li><a href="salesrep.html">Back</a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>

            <br><br><br><br><br><br>
            <div id="content">
                <h1 align="center">View all salesreps</h1><br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>salesrep employee id</th>
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

                            // select all salesreps from database and display all in the table
                            $sql_select_salesrep = "SELECT * FROM salesrep";
                            $query_result_salesrep = $conn->query($sql_select_salesrep);
                            $nrow = $query_result_salesrep->num_rows;

                            // check if there's any salesrep
                            if ($nrow === 0) {
                                echo "<p>No sales representative.</p>";
                            }
                            else {
                                while ($row = $query_result_salesrep->fetch_assoc()) {
                                    echo "<tr><td>".$row["employee_id"]."</td><td>".$row["username"]."</td><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["region"]."</td><td>".$row["tel"]."</td><td>".$row["email"]."</td><td>".$row["quota"]."</td><tr>";
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
            <br><HR><br>
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <h1 align="center">Modify salesrep's quota</h1><br>
                    <form role="form">
                        <div class="form-group">
							<label for="employee-id">Employee ID</label>
							<input class="form-control" id="employee-id" name="employee-id" type="text">
							<div id="validation-employee-id"></div>
						</div>
                        <div class="form-group">
							<label for="salesrep-quota">Quota</label>
							<input class="form-control" id="salesrep-quota" name="salesrep-quota" type="text">
							<div id="validation-quota"></div>
						</div><br>
                        <div class="form-group">
							<div id="message-area"></div>
							<input class="button" id="modify-quota-botton" name="modify-quota-botton" type="button" value="Modify quota">
						</div>
                    </form>
                </div>
            </div>
        </div>
        <br><br>
        <!--jQuery & bootstrap-->
        <script src="https://cdn.staticfile.org/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--validation-->
        <script src="../my_validation.js"></script>
        <script src="quota.js"></script>
    </body>
</html>