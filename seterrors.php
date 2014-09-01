<?php

$message = "wrong answer";
echo "<script type='text/javascript'>alert('$message');</script>";

//$con = mysqli_connect('localhost','scala_master','Tw3n+ysof+9ly','scalabrinedb');
$con = mysqli_connect('localhost','root','Tw0sof+9Ly','scalabrinedb');

/* pull the error information from the query string */
if (isset($_GET['url']))
  $url = htmlentities(substr(urldecode($_GET['url']),0,1024));
else
  $url = "";

if (isset($_GET['message']))
  $message = htmlentities(substr(urldecode($_GET['message']),0,1024));
else
  $message = "";

if (isset($_GET['line']))
  $line = htmlentities(substr(urldecode($_GET['line']),0,1024));
else
  $line = "";


/* record the Browser, IP address and time */
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$userIP =  $_SERVER['REMOTE_ADDR'];

date_default_timezone_set('America/Los_Angeles');
$currentTime = date("Y-m-d H:i:s");


/* add error to database */    
if ($SQL = $con->prepare("INSERT INTO jserrors (userAgent, url, line, message, userIP, time) VALUES (?,?,?,?,?,?)"))
{
  $message = "wrong";
  echo "<script type='text/javascript'>alert('$message');</script>";
  $SQL->bind_param('ssssss', $userAgent, $url, $line, $message, $userIP, $currentTime);
  $SQL->execute();
  $SQL->close();
}

// send the right headers
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("HTTP/1.1 204 No Content\n\n");
exit();     
?>