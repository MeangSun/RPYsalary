<?php
include("database/config.php");
include("database/J_MySQL.php");

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

$emp_id = $_POST["emp_id"];
$month = $_POST['month'];

echo "id ".$_POST["id"]."<br/>";
echo "time_in ".$_POST["time_in"]."<br/>";
echo "time_out ".$_POST["time_out"]."<br/>";
echo "work_check ".$_POST["work_check"]."<br/>";
echo "work_extra_check ".$_POST["work_extra_check"]."<br/>";
echo "special ".$_POST["special"]."<br/>";
echo "remark ".$_POST["remark"];


$ins["id"] = $_POST["id"];
$ins["time_in"] = $_POST["time_in"];
$ins["time_out"] = $_POST["time_out"];
$ins["work_check"] = $_POST["work_check"];
$ins["work_extra_check"] = $_POST["work_extra_check"];
$ins["special"] = $_POST["special"];
$ins["remark"] = $_POST["remark"];


$key=array(0);
$dbObj->J_Update($ins,$key,"work");

$dbObj->J_Close();


echo "<meta http-equiv=\"refresh\" content=\"2;url=cal_sal_calculate_edit.php?emp_id=".$emp_id."&month=".$month."\">"

?>