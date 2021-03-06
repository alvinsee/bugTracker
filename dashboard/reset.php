<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === '1')
{
  header("Location: /dashboard/index");
}
else
{
  require('functions.php');
 
  if (isset($_GET['a']) && $_GET['a'] == 'recover' && $_GET['email'] != "") 
  {
    $result = checkEmailKey(sanitize($_GET['email']),urldecode(base64_decode($_GET['u'])));
    if ($result == false)
    {
      // key does not match our key.. bad key
      header("Location: /dashboard/login");
    } 
    elseif ($result['status'] == true) 
    {
      // key is kewl
      $securityUser = $result['userID'];

      if(isset($_POST['reset'])) {
        // need to escape characters
        $password = sanitize($_POST['password']);
        $confirm_password = sanitize($_POST['confirm_password']);
        
        if (strcmp($password,$confirm_password) !== 0 || trim($password) === '')
        {
          // passwords dont match or password was empty
          $_SESSION['pass_match'] = true;
          header("Refresh:0");
        } 
        else 
        {
          updateUserPassword($securityUser, $password, sanitize($_GET['email']));
          // let user know it was successful and redirect to login
          header("Location: /dashboard/login");
        }
          
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="login">

  <title>scalabrine | reset password</title>

  <link rel="icon" href="/img/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />  
  <!-- Bootstrap core CSS -->
  <link href="/dashboard/css/bootstrap.min.css" rel="stylesheet">
  <link href="/dashboard/css/bootstrap-reset.css" rel="stylesheet">
  <!--external css-->
  <link href="/dashboard/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="/dashboard/css/style.css" rel="stylesheet">
  <link href="/dashboard/css/style-responsive.css" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="login-body">  
  <div class="container">
<?php
  if(isset($_SESSION['pass_match']))
  {
    $_SESSION['pass_match'] = false;
?>
  <div class="alert alert-danger" role="alert">passwords do not match.</div>
<?php
  }
?>
    <form class="form-signin" method="post">
      <h2 class="form-signin-heading">reset password</h2>
      <div class="login-wrap">
        <input type="password" class="form-control" name="password" placeholder="Password" autofocus />
        <input type="password" class="form-control" name="confirm_password" placeholder="Re-type Password" />

        <button class="btn btn-lg btn-login btn-block" name="reset" type="submit">reset</button>
        
      </div>

    </form>
  </div>

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="/dashboard/js/jquery.js"></script>
  <script src="/dashboard/js/bootstrap.min.js"></script>

<?php
}
?>
  </body>
</html>