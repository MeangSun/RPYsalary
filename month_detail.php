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

$month = $_GET['month'];

$fieldNames ="*";
$tableName ="holiday WHERE month =".$month;
?>

</head>
<body>
<div id="p1">Holiday in Month = <?php echo $month; ?></div>
<table id="table-a">
<tr>
<th width=50%>Date</th>
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
  		
  		echo "<td>" . $row['date'] . "</td>";
  		echo "<td>" . $row['remark'] . "</td>";
  		
  		echo "</tr>";
 }	
}
else echo "<tr><td span=\"2\">No records</td></tr>";
$dbObj->J_Close();
?>

</table>
<br/> 
<form id="centering"> 

<INPUT TYPE="button" id="button1" VALUE=" Add Holiday " onClick="parent.location='holiday_add.php'">
<INPUT TYPE="button" id="button1" VALUE=" Back to Home " onClick="parent.location='month_manage.php'">
</form>
</body>
</html>