<html>
<head>
<title>RPYTest</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php 
include("database/config.php");
include("database/J_MySQL.php");
include('style.css');

$month = $_GET['month'];
$emp_id = $_GET['emp_id'];

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

$fieldNames ="emp_name";
$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName); 
?>

</head>
<body>
<div id="p1">Employee Status</div>

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
<?php
$fieldName = "status";
$tableName = "employee_status WHERE emp_id=".$emp_id." AND month=".$month;
$result = $dbObj->J_Select($fieldName,$tableName);
	
if(count($result) > 0){
	foreach($result as $read)
	{
		$status=$read["status"];
	}
}
else $status=0;
?>
<table id="table-c">
<tr>
	<td  width="50%" align="right">
			Add Employee to this month :
	</td>
	<td  width="50%" align="left">
			
			<?
			if ($status==0)
			{
				echo "<a href=\"cal_sal_addemp2month.php?emp_id=".$emp_id."&month=".$month."\">Add</a>" ;
			}
			else if ($status>0)
			{
				echo "Complete!!!";
			}
			?>
	</td>
</tr>
<tr>
	<td  width="50%" align="right">
			Upload .txt file :
	</td>
	<td  width="50%" align="left">
			<?php
			if ($status<1) {
				echo "Not this step.";
			}
			else if ($status==1)
			{
				echo "<a href=\"cal_sal_addtxt.php?emp_id=".$emp_id."&month=".$month."\">Add</a>" ;
			}
			else if ($status>1)
			{
				echo "Complete!!!   "."<a href=\"result_add_txt.php?emp_id=".$emp_id."&month=".$month."\">View</a>";
			}
			?>
	</td>
</tr>
<tr>
	<td  width="50%" align="right">
			Add data to work DB :
	</td>
	<td  width="50%" align="left">
			<?php
			if ($status<2) {
				echo "Not this step.";
			}
			else if ($status==2)
			{
				echo "<a href=\"cal_sal_add2work2.php?emp_id=".$emp_id."&month=".$month."\">Add</a>" ;
			}
			else if ($status>2)
			{
				echo "Complete!!!   "."<a href=\"result_add_workDB.php?emp_id=".$emp_id."&month=".$month."\">View</a>";
			}
			?>
	</td>
</tr>
<tr>
	<td  width="50%" align="right">
			Calculate Salary :
	</td>
	<td  width="50%" align="left">
			<?php
			if ($status<3) {
				echo "Not this step.";
			}
			else if ($status==3)
			{
				echo "<a href=\"cal_sal_calculate2.php?emp_id=".$emp_id."&month=".$month."\">Calculate</a>" ;
			}
			else if ($status>3)
			{
				echo "Complete!!! ". "     |     "."<a href=\"cal_sal_calculate_view.php?emp_id=".$emp_id."&month=".$month."\">View</a>   ". "     |     "."<a href=\"cal_sal_calculate_edit.php?emp_id=".$emp_id."&month=".$month."\">  Edit</a>"
				." | "."<a href=\"cal_sal_genPDF2.php?emp_id=".$emp_id."&month=".$month."\" target=\"_blank\">Gen PDF</a>";
			}
			?>
	</td>
</tr>

</table>
<br/> 
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE="   Back   " onClick="parent.location='calculate_salary_detail.php?month=<?php echo $month;?>'">
</form>
<?php 
$dbObj->J_Close();
?>
</body>
</html>