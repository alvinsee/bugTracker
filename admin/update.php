<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
    header("Location: /dashboard/login");
}
else if ($_SESSION['admin'] != 2){
    header("HTTP/1.1 403 Forbidden");
    header("Location: /403");
}
else{

  require '../database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		
		// keep track post values
		$name = $_POST['name'];

		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter name';
			$valid = false;
		}
		
    $numRows = getNumRows('s', array(&$name), "SELECT name FROM organization WHERE id=?");

    $db_result = my_query('i', array(&$id), "SELECT name FROM organization where ID=?");


    if($valid)
    {
        $params = array(&$name);
        $sql = "UPDATE organization set name = ?";
        my_update('s', $params, $sql);

        $_SESSION['crud_update_success'] = true;
      }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="dashboard">

      <title>scalabrine | update</title>

      <link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
      <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
      <!-- Bootstrap core CSS -->
      <link href="/crud/css/bootstrap.min.css" rel="stylesheet">
      <link href="/dashboard/css/bootstrap-reset.css" rel="stylesheet">
      <!--external css-->
      <link href="/dashboard/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

      <!-- Custom styles for this template -->
      <link href="/dashboard/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />    
      <link href="/dashboard/css/style.css" rel="stylesheet">
      <link href="/dashboard/css/style-responsive.css" rel="stylesheet" />


      <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
      <!--[if lt IE 9]>
         <script src="/login/js/html5shiv.js"></script>
         <script src="/login/js/respond.min.js"></script>
      <![endif]-->  
</head>

<body>

   <div id="container" >

      <!--header start-->
      <header class="header white-bg">
         <div class="sidebar-toggle-box">
            <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
         </div>
         <!--logo start-->
         <a href="/dashboard/index" class="logo"><span>scalabrine</span></a>
         <!--logo end-->

         <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <a>
               <i class="icon-bell-alt"></i>
               last logged in: <?php echo $_SESSION['time'] ?>
               <br>
               <i class="icon-envelope"></i>
               current user's email: <?php echo $_SESSION['email'] ?>
            </a>
         </div>

         <div class="top-nav ">
            <!--user start-->
            
            <ul class="nav pull-right top-menu">
               
               <!-- user login dropdown start-->
               <li class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                     <img alt="" src="/dashboard/img/user.png" />
                     <span class="username"><?php echo $_SESSION['username'] ?></span>
                     <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu extended logout">
                     <li class="log-arrow-up"></li>
                     <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                     <li><a href="/dashboard/logout"><i class="icon-key"></i> Log Out</a></li>
                  </ul>
               </li>
               <!-- user login dropdown end -->
            </ul>
         </div>

      </header>
      <!--header end-->

      <!--sidebar start-->
      <aside>
         <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
               <li>
                  <a href="/dashboard/index">
                     <i class="icon-dashboard"></i>
                     <span>dashboard</span>
                  </a>
               </li>

               <li>
                  <a href="/dashboard/error_detail">
                     <i class="icon-tasks"></i>
                     <span>error details</span>
                  </a>
               </li>

               <li>
                  <a class="active" href="/crud/index">
                     <i class="icon-gear"></i>
                     <span>crud</span>
                  </a>
               </li>
               <li>
                  <a href="/jserrorreporter">
                     <i class="icon-exclamation"></i>
                     <span>error reporter</span>
                  </a>
               </li>
               <li>
                  <a href="/index">
                     <i class="icon-user"></i>
                     <span>home</span>
                  </a>
               </li>

            </ul>
            <!-- sidebar menu end-->
         </div>
      </aside>
      <!--sidebar end-->

      <!--main content start-->
      <div id="main-content">
         <div class="wrapper">
    
        <?php
            if($_SESSION['crud_update_already_username'] == true)
            {
              $_SESSION['crud_update_already_username'] = false;
        ?>
            <div class="alert alert-info" role="alert">username/email already taken</div>    
        <?php
            }
            if($_SESSION['crud_update_success'] == true)
            {
              $_SESSION['crud_update_success'] = false;
        ?>
            <div class="alert alert-info" role="alert">successful update</div>    
        <?php
            }
        ?>


    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a User</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Username" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index">Back</a>
						</div>
					</form>
				</div>
				
    	</div> 
    	</div>
    	<!-- /container -->
          <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2014 &copy; scalabrine.
              <a href="#" class="go-top">
                  <i class="icon-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->

   <!-- js placed at the end of the document so the pages load faster -->
   <script src="/dashboard/js/jquery-1.8.3.min.js"></script>
   <script src="/dashboard/js/bootstrap.min.js"></script>
   <script src="/dashboard/js/jquery.dcjqaccordion.2.7.js"></script>
   <script src="/dashboard/js/jquery.scrollTo.min.js"></script>
   <script src="/dashboard/js/jquery.nicescroll.js"></script>
   <script src="/dashboard/js/jquery.sparkline.js"></script>
   <script src="/dashboard/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
   <script src="/dashboard/js/jquery.customSelect.min.js" ></script>
   <script src="/dashboard/js/respond.min.js" ></script>

   <!--common script for all pages-->
   <script src="/dashboard/js/common-scripts.js"></script>      
  </body>
</html>
<?php } ?>