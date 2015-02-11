<html>
<head>
<title>RPYTest</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php 
include("database/config.php");
include("database/J_MySQL.php");
include('style.css');

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

$fieldNames ="*";
$tableName ="employee WHERE status = 1 ORDER BY emp_name";
?>

</head>
<body>
<div id="p1">Employee</div>
<table id="table-a">
<tr>
<th width=35%>Name</th>
<th width=35%>Type</th>
<th width=15%>Edit</th>
<th width=15%>Delete</th>
</tr>

<?php

$result = $dbObj->J_Select($fieldNames, $tableName); 

if(count($result) > 0){
 foreach($result as $row)
 {
		$iLoop++;
    	$bgcolor = ( ($iLoop%2)==0 )? "#CCFF99" : "#FFFFFF" ;
  		echo "<tr bgcolor=\"$bgcolor\">";
  		
  		echo "<td>" . $row['emp_name'] . "</td>";
  		echo "<td>" . $row['emp_type'] ."</td>";
  			
  		echo "<td>" . "<a href=\"employee_edit.php?&emp_id=". $row['emp_id']."\">Edit</a>" . "</td>";
  		echo "<td>" . "<a href=\"employee_delete.php?&emp_id=". $row['emp_id']. "&name=" . $row['emp_name'] ."\">Delete</a>" . "</td>";
  		echo "</tr>";
 }	
}
?>
</table>
<br/>
<br/>
<table id="table-a">
<tr>
<th width=35%>Name</th>
<th width=35%>Type</th>
<th width=15%>Edit</th>
<th width=15%>Delete</th>
</tr>
<?php 
$tableName ="employee WHERE status = 0 ORDER BY emp_name";
$result = $dbObj->J_Select($fieldNames, $tableName); 
if(count($result) > 0){
 foreach($result as $row)
 {
		$iLoop++;
    	$bgcolor = ( ($iLoop%2)==0 )? "#CCFF99" : "#FFFFFF" ;
  		echo "<tr bgcolor=\"$bgcolor\">";
  		
  		echo "<td>" . $row['emp_name'] . "</td>";
  		echo "<td>" . $row['emp_type'] ."</td>";
  			
  		echo "<td>" . "<a href=\"employee_edit.php?&emp_id=". $row['emp_id']."\">Edit</a>" . "</td>";
  		echo "<td>" . "<a href=\"employee_delete.php?&emp_id=". $row['emp_id']. "&name=" . $row['emp_name'] ."\">Delete</a>" . "</td>";
  		echo "</tr>";
 }	
}
?>
</table>
<?
$dbObj->J_Close();
?>

<br/> 
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Add Employee " onClick="parent.location='employee_add.php'">
<INPUT TYPE="button" id="button1" VALUE=" Back to Home " onClick="parent.location='index.php'">
</form>
</body>
</html>