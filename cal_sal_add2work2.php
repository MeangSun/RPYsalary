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
$error=0;

$ins["emp_id"] = $emp_id;
$ins["month"] = $month;
?>
<body>
<?php	
$dateCount=1;
$count="";
$moreTwo;


	
for ($i = 1; $i <= 31; $i++) {
	
	$ins["date"]=$i;
	
	$tableName ="data_from_txt WHERE emp_id=".$emp_id." AND month=".$month." AND date=".$i." ORDER BY  checktime";
	$result = $dbObj->J_Select($fieldNames, $tableName); 
	
	if(count($result) > 0) {	
		if(count($result) == 1) {	
			$count="count1";
		}
		if(count($result) > 2) {	
			$count="more2";
		}
		foreach($result as $row){		
			if ($row["state"]=="C/In") {
				$ins["time_in"] = $row["checktime"];
			}
			else if ($row["state"]=="C/Out") {					
				$ins["time_out"] = $row["checktime"];
			}
		}
		if ($ins["time_in"] != "" || $ins["time_out"] != "") {
			$dbObj->J_Insert($ins, "work");
			print_r($ins);
			echo $count."<br>";
		}
	
		$fieldName = "id";
		$tableName = "employee_status WHERE emp_id=".$emp_id." AND month=".$month;
		      
		$result = $dbObj->J_Select($fieldName,$tableName);
		if(count($result) > 0) {
			foreach($result as $read) {
				  $status_id = $read["id"];
				  $ins2["id"]=$status_id;
				  $ins2["status"]="3";
				  $key=array(0);
				  $dbObj->J_Update($ins2,$key,"employee_status");
			}
		}
		
		$count="";
		$ins["time_in"] = "";
		$ins["time_out"] = "";
		
	}
	else $error=1;
}
if ($error==1) {
	echo "<div id=\"error_messege\" align=\"center\"> No data to add to Work DB <div>";
}

      
$dbObj->J_Close();

?>
<br/>
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
</html>