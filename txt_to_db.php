<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include("database/config.php");
include("database/J_MySQL.php");

$ins["emp_id"] = $_GET['emp_id'];
$ins["month"] = $_GET['month'];
$lines = file("data/".$_GET['fileName']);

$dbObj = new J_SQL;

$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

foreach($lines as $line) {
	$line=trim($line);
	
	if ($line!="Time State" && $line!="") {
		//echo($line."<br>");
		$arr = explode ( " ", $line );
		
		$ins["date"] = stristr($arr[0], '/', true);
		$ins["checktime"] = $arr[1];
		if ($arr[2]==NULL) {
			$ins["state"] = $arr[3];
		}
		else $ins["state"] = $arr[2];

		$dbObj->J_Insert($ins,"data_from_txt"); 
		
		echo($ins[date]." - ".$ins["checktime"]." ".$ins["state"]."<br>");
		
	}
}

$dbObj->J_Close();


echo "<meta http-equiv=\"refresh\" content=\"3;url=cal_sal_emp_detail.php?emp_id=".$_GET['emp_id']."&month=".$_GET['month']."\">"

?> 

</html>