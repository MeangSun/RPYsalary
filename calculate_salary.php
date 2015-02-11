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
$tableName ="month ORDER BY year, month";
?>

</head>
<body>
<div id="p1">Calculate Salary</div>
<table id="table-a">
<tr>
<th width=50%>Month</th>
<th width=50%>Detial</th>
</tr>

<?php

$result = $dbObj->J_Select($fieldNames, $tableName); 

if(count($result) > 0){
 foreach($result as $row)
 {
		$iLoop++;
    	$bgcolor = ( ($iLoop%2)==0 )? "#CCFF99" : "#FFFFFF" ;
  		echo "<tr bgcolor=\"$bgcolor\">";
  		
  		echo "<td>" . $row['month'] . "/" . $row['year'] . "</td>";
  		echo "<td>" . "<a href=\"calculate_salary_detail.php?month=". $row['month'] . $row['year'] ."\">Detial</a>" . "</td>";
  		//echo "<td>" . "<a href=\"employee_edit.php?&emp_id=". $row['emp_id']."\">Edit</a>" . "</td>";
  		echo "</tr>"; 
 }	
}
$dbObj->J_Close();
?>

</table>
<br/> 
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE="   Back   " onClick="parent.location='index.php'">
</form>
</body>
</html>