<?php
$dbName = 'scalabrinedb'; 
$dbHost = 'localhost';
$dbUsername = 'scala_master';  
$dbUserPassword = 'Tw3n+ysof+9Ly'; 

$con  = new mysqli($dbHost,$dbUsername,$dbUserPassword,$dbName);

function getNumRows($type, $param, $query)
{
  global $con;
  $stmt = $con->prepare($query);
  call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $param));
  $stmt->execute();
  $stmt->store_result();
  $numRows = $stmt->num_rows();
  $stmt->close();

  return $numRows;
}

function my_update($type, $param, $query)
{
  global $con;
  $stmt = $con->prepare($query);
  call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $param));
  $stmt->execute();
  $err = $con->errno;
  $stmt->close();

  return $err;
}

function my_query($type, $param, $query)
{
  global $con;
  $stmt = $con->prepare($query);
  call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $param));
  $stmt->execute();

  $meta = $stmt->result_metadata(); 
  while ($field = $meta->fetch_field()) 
  { 
    $params[] = &$row[$field->name];
  }

  call_user_func_array(array($stmt, 'bind_result'), $params); 

  while ($stmt->fetch()) { 
    foreach($row as $key => $val) 
    { 
      $result[$key] = $val;
    } 
  } 

  $stmt->close();

  return $result;
}

function my_disconnect()
{
  global $con;
  $con->close();  
}

function sanitize($str)
{
  global $con;
  return $con->real_escape_string($str);
}

?>