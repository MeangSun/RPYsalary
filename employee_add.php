<html>
<head>
<title>RPYTest | Add Employee Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include('style.css');
include("database/config.php");
include("database/J_MySQL.php");

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

if($_POST['chk']==1){
	$ins["emp_name"] = $_POST['emp_name'];
	$ins["emp_type"] = $_POST['emp_type'];
	$ins["wage_per_day"] = $_POST['wage_per_day'];
	$ins["wage_per_month"] = $_POST['wage_per_month'];
	$ins["wage_extra"] = $_POST['wage_extra'];
	$ins["social_security"] = $_POST['social_security'];
	$ins["dis_wage_per_day"] = $_POST['dis_wage_per_day'];
	$ins["dis_extra_per_day"] = $_POST['dis_extra_per_day'];
	$ins["count_holiday"] = $_POST['count_holiday'];
	$ins["holiday_week"] = $_POST['holiday_week'];
	$ins["double_day_week"] = $_POST['double_day_week'];
	$ins["telephone"] = $_POST['telephone'];
	$ins["remark"] = $_POST['remark'];
	
	$dbObj->J_Insert($ins, "employee");
	echo"<meta http-equiv='refresh' content='0; url=employee_manage.php'>";
}
?>
</head>
<body>

<form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
<table id="table-b">
<tr align="center" >
	<th colspan="2">Add Employee</th>
</tr>

<tr>
	<td align="right" width=50%>Name : </td> 
	<td align="left"  width=50%><input type="text" name="emp_name"></td>
</tr>
<tr>
	<td align="right" >Type : </td>
	<td align="left"> 
		<select name="emp_type">
  			<option value="1"> 1   </option>
  			<option value="2"> 2   </option>
  			<option value="3"> 3   </option>
  			<option value="4"> 4   </option>
  			<option value="5"> 5   </option>
		</select>
	</td>	
</tr>	
<tr>
	<td align="right">Wage per Day : </td> 
	<td align="left"><input type="text" name="wage_per_day"></td>
</tr>
<tr>
	<td align="right">Wage per Month : </td> 
	<td align="left"><input type="text" name="wage_per_month"></td>
</tr>
<tr>
	<td align="right">Wage Extra : </td> 
	<td align="left"><input type="text" name="wage_extra"></td>
</tr>
<tr>
	<td align="right">Social Security : </td> 
	<td align="left"><input type="text" name="social_security"></td>
</tr>
<tr>
	<td align="right">Dis Wage per Day : </td> 
	<td align="left"><input type="text" name="dis_wage_per_day"></td>
</tr>
<tr>
	<td align="right">Dis Extra per Day : </td> 
	<td align="left"><input type="text" name="dis_extra_per_day"></td>
</tr>
<tr>
	<td align="right">Count Holiday  : </td> 
	<td align="left"><input type="text" name="count_holiday"></td>
</tr>
<tr>
	<td align="right">Holiday Week  : </td> 
	<td align="left">
		<select name="holiday_week">
			<option value="0"> None   </option>
  			<option value="1"> Monday   </option>
  			<option value="2"> Tueday   </option>
  			<option value="3"> Wednesday   </option>
  			<option value="4"> Thursday   </option>
  			<option value="5"> Friday   </option>
  			<option value="6"> Saturday   </option>
  			<option value="7"> Sunday   </option>
  		</select>
	</td>
</tr>
<tr>
	<td align="right">Doubleday Week  : </td> 
	<td align="left">
		<select name="double_day_week">
			<option value="0"> None   </option>
  			<option value="1"> Monday   </option>
  			<option value="2"> Tueday   </option>
  			<option value="3"> Wednesday   </option>
  			<option value="4"> Thursday   </option>
  			<option value="5"> Friday   </option>
  			<option value="6"> Saturday   </option>
  			<option value="7"> Sunday   </option>
  		</select>
	</td>
</tr>
<tr>
	<td align="right">Telephone  : </td> 
	<td align="left"><input type="text" name="telephone"></td>
</tr>
<tr>
	<td align="right" valign="top">Remark  : </td> 
	<td align="left"><textarea rows="10" cols="30" name="remark"></textarea></td>
</tr>


<tr> 
	<td align="center" colspan="2">  
		<input type="submit" id="button1" name="Submit" value=" Add Employee ">
		<input type="button" id="button1" value=" Cancel " onClick="parent.location='employee_manage.php'"> 
		<input type="hidden" name="chk" id="chk" value="1" />
	</td> 
</tr>

</table>
</form>

</body>
<?php $dbObjo->J_Close(); ?>
</html>