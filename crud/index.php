<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header("Location: /dashboard/login");
}
else if ($_SESSION['admin'] == 0){
    header("HTTP/1.1 403 Forbidden");
    header("Location: /403");
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>User Management</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Username</th>
		                  <th>Email Address</th>
                          <th>Role</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
                       if ($_SESSION['admin'] == 2){
					       $sql = 'SELECT * FROM user ORDER BY ID DESC';
                       }
                       else{
                           $sql = 'SELECT * FROM user WHERE OrgID = ' . $_SESSION['orgID'] . ' ORDER BY ID DESC';
                       }
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Username'] . '</td>';
							   	echo '<td>'. $row['Email'] . '</td>';

                                switch($row['admin']){
                                    case 0:
                                        $role = 'User';
                                        break;
                                    case 1:
                                       $role = 'Admin';
                                       break;
                                    case 2:
                                       $role = 'Developer';
                                       break;
                                }
                                echo '<td>'. $role . '</td>';

                                echo '<td style="white-space:nowrap;">';
							   	echo '<a class="btn" href="read.php?id='.$row['ID'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['ID'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['ID'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
<?php
}
?>