<?php
include("database/config.php");
include("database/J_MySQL.php");

$ins2["emp_id"] = $_GET['emp_id'];
$ins2["month"] = $_GET['month'];
$ins2["status"] = 1;

$dbObj2 = new J_SQL;

$dbObj2->J_ConnectDB();
$dbObj2->J_SelectDB();
$dbObj2->set_char_utf8();


$dbObj2->J_Insert($ins2,"employee_status"); 
$dbObj2->J_Close();

echo "<meta http-equiv=\"refresh\" content=\"0;url=cal_sal_emp_detail.php?emp_id=".$_GET['emp_id']."&month=".$_GET['month']."\">"

?> 