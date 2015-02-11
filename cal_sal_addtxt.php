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

$fieldNames ="emp_name";
$tableName ="employee WHERE emp_id=".$emp_id;

$result = $dbObj->J_Select($fieldNames, $tableName); 

if(count($result) > 0){
 foreach($result as $row)
 {
 	$name = $row['emp_name'];
 }
}
?>
<body>
<form action="upload_file.php" method="post" enctype="multipart/form-data" name="form1">

<div>  </div>
<table id="table-b">
<tr>
	<th align="center">Upload Text File</th>
</tr>
<tr>
	<td align="center">Month = <?php echo $month; ?> Name = <?php echo $name?></td>
</tr>
<tr>

<td align="center">File:
<input type="file" name="file" id="file"> 
<br>
</td>
</tr>
<tr>
<td align="center">
<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id?>" />
<input type="hidden" name="month" id="month" value="<?php echo $month?>" />

<input type="submit" id="button1" name="submit" value=" Submit ">
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</td>
</tr>
</table>
</form>
</body>
</html>