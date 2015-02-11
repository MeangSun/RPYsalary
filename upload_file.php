<html>
<head>
<title>RPYTest | Edit User Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include('style.css');

include("database/config.php");
include("database/J_MySQL.php");

?>

</head>
<body>
<form name="form1">
<table id="table-b">
<tr>
	<th align="center">Upload</th>
</tr>
<tr>

<?php

$check=0;

$juice = new J_SQL;
$juice->J_ConnectDB();
$juice->J_SelectDB();
$juice->set_char_utf8();

$month = $_POST['month'];
$emp_id = $_POST['emp_id'];
$fileName = $month."-".$_FILES["file"]["name"];

if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    if (file_exists("data/" . $month . "-" .$_FILES["file"]["name"]))
      {
      	echo "<td id=\"error_messege\" align=\"center\">";
      echo $month . "-" .$_FILES["file"]["name"] . " already exists. <br/>Try again.";
      }
    else
      { 
      	echo "<td align=\"center\">";
      	echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    	echo "Type: " . $_FILES["file"]["type"] . "<br />";
    	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "data/" . $month . "-" .$_FILES["file"]["name"]);
      echo "Stored in: " . "data/" . $month . "-" .$_FILES["file"]["name"];
      
      $fieldName = "id";
	  $tableName = "employee_status WHERE emp_id=".$emp_id." AND month=".$month;
      
	  $result = $juice->J_Select($fieldName,$tableName);
      if(count($result) > 0){
		 foreach($result as $read)
		 {
		  	$status_id = $read["id"];
		  	$ins["id"]=$status_id;
		  	$ins["status"]="2";
		  	$key=array(0);
		  	$juice->J_Update($ins,$key,"employee_status");
		 }
		 $check=1;
		}
      }
    }
    
    

    $juice->J_Close();
?>
<br/>
<?php 
if ($check==1) {
	echo "<INPUT TYPE=\"button\" id=\"button1\" VALUE=\" Add .txt to DB \" onClick=\"parent.location='txt_to_db.php?emp_id=".$emp_id."&month=".$month."&fileName=".$fileName."'\">";
}
else echo "<INPUT TYPE=\"button\" id=\"button1\" VALUE=\" Back \" onClick=\"parent.location='cal_sal_emp_detail.php?emp_id=".$emp_id."&month=".$month."'\">";
?>
</td>
</tr>
</table>
</form>
</body>
</html>