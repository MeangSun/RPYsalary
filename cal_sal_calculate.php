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

$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $read) {
		
	}
}

$tableName ="work WHERE emp_id = ".$emp_id." AND month = ".$month." ORDER BY date";
$result = $dbObj->J_Select($fieldNames, $tableName);


$date=0;
$numDaysInMonth = date("t", mktime(0, 0, 0, substr($month, 0, 2), 1, substr($month, -4)));
$printRow=0;

$TotalWorkDay=0;

//$ins["emp_id"] = $emp_id;
//$ins["month"] = $month;
?>
<body>
<table align="center">
<tr>
	<td>
		<table id="table-f">
			<tr>
				<td width="30 px"> วันที่</td>
				<td width="30 px">วัน</td>
				<td width="60 px">เวลาเช้า</td>
				<td width="60 px">เวลาออก</td>
				<td width="35 px">ทำงาน</td>
				<td width="35 px">พิเศษ</td>
				<td width="35 px"></td>
				<td width="200 px">หมายเหตุ</td>
			</tr>
			<?php 
			for ($i = 1; $i <= 16; $i++) {
				if(count($result) > 0){
					foreach($result as $row)
					{
						if ($i==$row["date"]) {
							echo "<tr>";
							
							echo "<td>".$i."</td>";
							echo "<td>". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
							echo "<td>".$row["time_in"]."</td>";
							echo "<td>".$row["time_out"]."</td>";
							echo "<td>". checkWorking($row["time_in"], $row["time_out"])."</td>";
								$TotalWorkDay += checkWorking($row["time_in"], $row["time_out"]);
							echo "<td>"."</td>";
							echo "<td>"."</td>";
							echo "<td>"."</td>";
							
							echo "</tr>";
							$printRow=1;
						}
					}
				}
				if (!$printRow) {
					echo "<tr>";
							
					echo "<td>".$i."</td>";
					echo "<td>". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
					echo "<td> 0 </td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
							
					echo "</tr>";
				}
				$printRow=0;
			}
			?>
		</table>
	</td>
	<td>
		<table id="table-f">
			<tr>
				<td width="30 px"> วันที่</td>
				<td width="30 px">วัน</td>
				<td width="60 px">เวลาเช้า</td>
				<td width="60 px">เวลาออก</td>
				<td width="35 px">ทำงาน</td>
				<td width="35 px">พิเศษ</td>
				<td width="35 px"></td>
				<td width="200 px">หมายเหตุ</td>

			</tr>
			<?php 
			for ($i = 17; $i <= $numDaysInMonth; $i++) {
				if(count($result) > 0){
					foreach($result as $row)
					{
						if ($i==$row["date"]) {
							echo "<tr>";
							
							echo "<td>".$i."</td>";
							echo "<td>". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
							echo "<td>".$row["time_in"]."</td>";
							echo "<td>".$row["time_out"]."</td>";
							echo "<td>". checkWorking($row["time_in"], $row["time_out"])."</td>";
								$TotalWorkDay += checkWorking($row["time_in"], $row["time_out"]);
							echo "<td>"."</td>";
							echo "<td>"."</td>";
							echo "<td>"."</td>";
							
							echo "</tr>";
							$printRow=1;
						}
					}
				}
				if (!$printRow) {
					echo "<tr>";
							
					echo "<td>".$i."</td>";
					echo "<td>". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
					echo "<td> 0 </td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
							
					echo "</tr>";
				}
				$printRow=0;
				$date=$i;
			}
			for ($date; $date < 31; $date++) {
				echo "<tr>";
				
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				echo "<td>"."</td>";
				
				echo "</tr>";
			}
			?>
			<tr>
				<td colspan="4"> รวม </td>
				<td colspan="2"> <?php echo $TotalWorkDay;?> </td>
				<td colspan="2">  </td>
			</tr>
			
		</table>
	</td>
</tr>
</table>
<?php	
function getThDateWeek($date_eng) {
	switch ($date_eng) {
		
		case 1:
			$dateTh="จ.";
		break;
		case 2:
			$dateTh="อ.";
		break;
		case 3:
			$dateTh="พ.";
		break;
		case 4:
			$dateTh="พฤ.";
		break;
		case 5:
			$dateTh="ศ.";
		break;
		case 6:
			$dateTh="ส.";
		break;
		case 7:
			$dateTh="อา.";
		break;
	}
	return $dateTh;
}
function checkWorking($in,$out) {
	if ($in == "" || $out =="") {
		return 0.5;
	}
	else return 1;
}


?>
<br/>
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
<?php 
$dbObj->J_Close();
?>
</html>