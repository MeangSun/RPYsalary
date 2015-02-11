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

$emp_id = $_GET['emp_id'];
$month = $_GET['month'];


$fieldNames ="emp_name";
$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName); 
?>

</head>
<body>
<div id="p1">Result Data(txt)</div>
<table id="table-c">
<tr>
	
	<td  width="50%" align="center">
	
			Name : <?php 
			foreach($result as $row)
		 	{
				echo $row["emp_name"];
		 	}
			?>
			
	</td>
	<td  width="50%" align="center">
			Month : <?php echo $month?>
	</td>
</tr>

</table>
<br/>
<table id="table-a">
<tr>
<th width=20%>Date</th>
<th width=20%>CheckTime</th>
<th width=20%>State</th>
</tr>

<?php
$fieldNames ="*";
$tableName ="data_from_txt WHERE emp_id = ".$emp_id." AND month = ".$month." ORDER BY date ,state ,checktime";
$result = $dbObj->J_Select($fieldNames, $tableName); 

if(count($result) > 0){
 foreach($result as $row)
 {
		$iLoop++;
    	$bgcolor = ( ($iLoop%2)==0 )? "#CCFF99" : "#FFFFFF" ;
  		echo "<tr bgcolor=\"$bgcolor\">";
  		echo "<td>" . $row['date'] . "</td>";
  		echo "<td>" . $row['checktime'] . "</td>";
  		echo "<td>" . $row['state'] . "</td>";
  		
  		echo "</tr>";
 }	
}
$dbObj->J_Close();
?>

</table>
<br/> 
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
</html>