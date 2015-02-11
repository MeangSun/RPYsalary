<?php
$hostname = "localhost:8889";
$user = "root";
$password = "root";
$dbname = "RPYsalary"; 

$con = mysql_connect($hostnme,$user,$password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
  mysql_select_db($dbname, $con);
  mysql_query("SET NAMES UTF8");
  
?>