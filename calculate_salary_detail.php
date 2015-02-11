<html>
<head>
<title>RPYTest</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php 
include("database/config.php");
include("database/J_MySQL.php");
include('style.css');

$month = $_GET['month'];

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();


$fieldNames ="*";
$tableName ="employee WHERE status = 1 ORDER BY emp_name";

$dbObj2 = new J_SQL;
$dbObj2->J_ConnectDB();
$dbObj2->J_SelectDB();
$dbObj2->set_char_utf8();


$fieldNames2 ="status";

//$status ="";
?>

</head>
<body>
<div id="p3">Salary Month = <?php echo $month; ?></div>
<table id="table-e">
<tr>
<th width=30%>Name</th>
<th width=30%>Detail</th>
<th width=40%>Status</th>
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
  		echo "<td>" . "<a href=\"cal_sal_emp_detail.php?emp_id=".$row['emp_id']."&month=".$month."\">Detail</a>" . "</td>";
  		
  		echo "<td>";
  		
		$tableName2 ="employee_status WHERE month=".$month." AND emp_id=".$row['emp_id'];
		$result2 = $dbObj2->J_Select($fieldNames2, $tableName2);
  		if (count($result2) > 0) {
  			foreach($result2 as $row2) {
 				switch ($row2['status']) {
 				case 1:
 					//("<a href=\"cal_sal_addtxt.php?emp_id=".$row['emp_id']."&month=".$month."\">Add file .txt</a>");
 					echo "1 : Add Employee Complete";
 					break;
 				case 2:
 					//("2");
 					echo "2 : Add .txt Complete";
 					break;
 				case 3:
 					//("2");
 					echo "3 : Add to work DB Complete";
 					break;
 				case 4:
 					//("2");
 					echo "4 : Complete | " . "<a href=\"cal_sal_genPDF2.php?emp_id=".$row['emp_id']."&month=".$month."\" target=\"_blank\">PDF</a>";
 					break;	
 				}
 			}
  		}
  		else {
  			//echo("<a href=\"cal_sal_addemp2month.php?emp_id=".$row['emp_id']."&month=".$month."\">Add Emp to this month</a>");
  			echo "0 : Not add Emp to this month";
  		}
  		
  		
  		echo "</td>";
  		echo "</tr>";
 }	
}
$dbObj->J_Close();
//$dbObj2->J_Close();

?>

</table>
<br/> 
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE="   Back   " onClick="parent.location='calculate_salary.php'">
</form>
</body>
</html>