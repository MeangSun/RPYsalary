<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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

$fieldNames ="*";
$tableName ="data_from_txt WHERE emp_id=".$emp_id." AND month=".$month." ORDER BY  date, checktime";

$ins["emp_id"] = $emp_id;
$ins["month"] = $month;
?>
<body>
<?php	

$date_current=1;
$date_previous=1;

$dateCount=1;
$count=0;
$moreTwo;

$result = $dbObj->J_Select($fieldNames, $tableName); 
	
if(count($result) > 0) {	 	
	foreach($result as $row){		
		
		if($row["date"]==$dateCount) {
			$count++;	
			
			$ins["date"]=$row["date"];
			
			if ($row["state"]=="C/In") {
				$ins["time_in"] = $row["checktime"];
			}
			else if ($row["state"]=="C/Out") {					
				$ins["time_out"] = $row["checktime"];
			}
			if ($count>2) {
				$moreTwo="more 2";
			}
			
		}
		else {
			print_r($ins);
			echo $moreTwo."<br>";
			
			$ins["date"]=$row["date"];
			
			if ($row["state"]=="C/In") {
				$ins["time_in"] = $row["checktime"];
			}
			else if ($row["state"]=="C/Out") {					
				$ins["time_out"] = $row["checktime"];
			}
			if ($count>2) {
				$moreTwo="more 2";
			}
			
			$moreTwo="";
			$dateCount++;
			$count=0;
		}
		
		
	}		
}




$dbObj->J_Close();

?>
<br/>
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
</html>