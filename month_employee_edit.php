<html>
<head>
<title>RPYTest | Add Employee Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include('style.css');
include("database/config.php");
include("database/J_MySQL.php");

$month = $_GET['month'];
$emp_id = $_GET['emp_id'];

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

if($_POST['chk']==1){
	$ins["id"] = $_POST['id'];
	$ins["emp_id"] = $_POST['emp_id'];
	$ins["month"] = $_POST['month'];
	$ins["withdraw10"] = $_POST['withdraw10'];
	$ins["withdraw20"] = $_POST['withdraw20'];
	$ins["commission"] = $_POST['commission'];
	$ins["delivery"] = $_POST['delivery'];
	$ins["not_work"] = $_POST['not_work'];
	$ins["etc_txt"] = $_POST['etc_txt'];
	$ins["etc"] = $_POST['etc'];
	
	$key = array(0);
	
	$dbObj->J_Update($ins, $key, "month_employee");
	echo"<meta http-equiv='refresh' content='0; url=cal_sal_calculate_edit.php?emp_id=".$emp_id."&month=".$month."'>";
}

$fieldNames ="*";
$tableName ="month_employee WHERE emp_id = ".$emp_id." AND month = ".$month;

$result = $dbObj->J_Select($fieldNames, $tableName); 

if(count($result) > 0){
 foreach($result as $row)
 {
?>

</head>
<body>

<form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
<table id="table-b">
<tr align="center" >
	<th colspan="2">Add Employee</th>
</tr>

<tr>
	<td align="right" width=50%>Withdraw 10 : </td> 
	<td align="left"  width=50%><input type="text" name="withdraw10" value=<?php echo $row["withdraw10"]?>></td>
</tr>
<tr>
	<td align="right">Withdraw 20 : </td> 
	<td align="left"><input type="text" name="withdraw20" value=<?php echo $row["withdraw20"]?>></td>
</tr>
<tr>
	<td align="right">commission : </td> 
	<td align="left"><input type="text" name="commission" value=<?php echo $row["commission"]?>></td>
</tr>
<tr>
	<td align="right">delivery : </td> 
	<td align="left"><input type="text" name="delivery" value=<?php echo $row["delivery"]?>></td>
</tr>
<tr>
	<td align="right">not_work : </td> 
	<td align="left"><input type="text" name="not_work" value=<?php echo $row["not_work"]?>></td>
</tr>
<tr>
	<td align="right">etc_txt : </td> 
	<td align="left"><input type="text" name="etc_txt" value=<?php echo $row["etc_txt"]?>></td>
</tr>
<tr>
	<td align="right">etc : </td> 
	<td align="left"><input type="text" name="etc" value=<?php echo $row["etc"]?>></td>
</tr>

<tr> 
	<td align="center" colspan="2">  
		<input type="submit" id="button1" name="Submit" value=" Add Monthly Data ">
		<input type="button" id="button1" value=" Cancel " onClick="parent.location='cal_sal_calculate_edit.php?emp_id=<?php echo $emp_id;?>&month=<?php echo $month ?>'"> 
		<input type="hidden" name="chk" id="chk" value="1" />
		<input type="hidden" name="id" id="id" value=<?php echo  $row["id"];?>/>
		<input type="hidden" name="emp_id" id="emp_id" value=<?php echo  $emp_id;?>/>
		<input type="hidden" name="month" id="month" value=<?php echo  $month;?>/>
	</td> 
</tr>

</table>
</form>

</body>
<?php 
 }
}
$dbObjo->J_Close(); ?>
</html>