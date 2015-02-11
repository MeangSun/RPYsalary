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
	$ins["month"] = $_POST['month'];
	$ins["year"] = $_POST['year'];
	
	
	$dbObj->J_Insert($ins, "month");
	echo"<meta http-equiv='refresh' content='0; url=month_manage.php'>";
}
?>
</head>
<body>

<form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
<table id="table-b">
<tr align="center" >
	<th colspan="2">Add Month</th>
</tr>


<tr>
	<td align="right" >Month : </td>
	<td align="left"> 
		<select name="month">
  			<option value="01"> 1   </option>
  			<option value="02"> 2   </option>
  			<option value="03"> 3   </option>
  			<option value="04"> 4   </option>
  			<option value="05"> 5   </option>
  			<option value="06"> 6   </option>
  			<option value="07"> 7   </option>
  			<option value="08"> 8   </option>
  			<option value="09"> 9   </option>
  			<option value="10"> 10   </option>
  			<option value="11"> 11   </option>
  			<option value="12"> 12   </option>
  			
		</select>
	</td>	
</tr>	
<tr>
	<td align="right" width=50%>Year : </td> 
	<td align="left"  width=50%><input type="text" name="year"></td>
</tr>
<tr> 
	<td align="center" colspan="2">  
		<input type="submit" id="button1" name="Submit" value=" Add Month ">
		<input type="button" id="button1" value=" Cancel " onClick="parent.location='month_manage.php'"> 
		<input type="hidden" name="chk" id="chk" value="1" />
	</td> 
</tr>

</table>
</form>

</body>
<?php $dbObjo->J_Close(); ?>
</html>