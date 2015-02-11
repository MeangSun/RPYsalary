<?php
include("database/config.php");
include("database/J_MySQL.php");

$ins["emp_id"] = 1;
$ins["month"] = "032011";
$lines = file("01.txt");


$dbObj = new J_SQL;

$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();  // เรียกใช้ฟังก์ชั่น J_SelectDB()
$dbObj->set_char_utf8(); // เรียกใช้ฟังก์ชั่น set_char_utf8()

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

?> 