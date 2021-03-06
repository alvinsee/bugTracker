<?php

require("database.php");

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

if (isset($_GET['orgID']))
  $orgid = htmlentities(substr(urldecode($_GET['orgID']),0,1024));
else
  $orgid = "";

$userAgent = $_SERVER['HTTP_USER_AGENT'];
$userIP =  $_SERVER['REMOTE_ADDR'];

date_default_timezone_set('America/Los_Angeles');
$currentTime = date("Y-m-d H:i:s");

/* add error to database */    
$sql = "INSERT INTO jserrors (userAgent, url, line, message, userIP, time, orgid) VALUES (?,?,?,?,?,?,?)";
$param = array(&$userAgent, &$url, &$line, &$message, &$userIP, &$currentTime, &$orgid);
my_update('sssssss', $param, $sql);

// send the right headers
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("HTTP/1.1 204 No Content\n\n");
exit();

?>
