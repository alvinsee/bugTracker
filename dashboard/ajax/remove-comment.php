<?php
session_start();
extract($_POST);

  echo "NOT WORKING";
if($_POST['act'] == 'rm-com')
{
  // Connect to the database
  include('../config2.php'); 

  echo "WORKING";
  //insert the comment in the database
  mysql_query("DELETE FROM comments WHERE name='$name' and email='$email' and id_post='$id_post')");

}

?>