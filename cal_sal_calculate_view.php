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
//
//$dbObj2 = new J_SQL;
//$dbObj2->J_ConnectDB();
//$dbObj2->J_SelectDB();
//$dbObj2->set_char_utf8();


$emp_id = $_GET['emp_id'];
$month = $_GET['month'];

$fieldNames ="*";
$tableName ="holiday WHERE month = ".$month. " ORDER BY date";
$result = $dbObj->J_Select($fieldNames, $tableName);

$numHoliday=0;
if(count($result) > 0) {
	foreach($result as $row) {
		$holiday[$numHoliday]["date"]=$row["date"];
		$holiday[$numHoliday]["remark"]=$row["remark"];
		$numHoliday++;
	}
}
$is_holiday_week=0;
$is_holiday=0;

$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $row) {
		$double_day_week=$row["double_day_week"];
		$holiday_week=$row["holiday_week"];
		$emp_type=$row["emp_type"];
		$emp_name=$row["emp_name"];
	}
}
$is_double=0;
//$TotalAllowance=0;
//
$tableName ="work WHERE emp_id = ".$emp_id." AND month = ".$month." ORDER BY date";
$result = $dbObj->J_Select($fieldNames, $tableName);
//
//
$numDaysInMonth = date("t", mktime(0, 0, 0, substr($month, 0, 2), 1, substr($month, -4)));
//$printRow=0;

$TotalWorkDay=0;

//$ins["emp_id"] = $emp_id;
//$ins["month"] = $month;
?>
<body>
<?php 
echo "Name : ". $emp_name ." Month : ".$month;
?>
<br>
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
			for ($i = 1; $i <= $numDaysInMonth; $i++) {
				if ($i==17) {
					echo("</table>
							</td>
							<td>
								<table id=\"table-f\">
									<tr>
										<td width=\"30 px\"> วันที่</td>
										<td width=\"30 px\">วัน</td>
										<td width=\"60 px\">เวลาเช้า</td>
										<td width=\"60 px\">เวลาออก</td>
										<td width=\"35 px\">ทำงาน</td>
										<td width=\"35 px\">พิเศษ</td>
										<td width=\"35 px\"></td>
										<td width=\"200 px\">หมายเหตุ</td>
										
									</tr>");
				}
				for ($j = 0; $j < $numHoliday; $j++) {
					if($i==$holiday[$j]["date"]){
						$HLDcolor ="#CCFF99"; 
					}
				}
				
				
				
				if($double_day_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))
				{
					$DayColor="#CCFF99"; 
				}
				elseif($holiday_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))
				{
					$DayColor="#CCFF99"; 
				}
				if(count($result) > 0){
					foreach($result as $row)
					{
						if ($i==$row["date"]) {
							echo "<form>"."<tr>";
							
							echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
							echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))."</td>";
//							echo "<td >"."</td>";
//							echo "<td>"."</td>";
							echo "<td>".$row["time_in"]."</td>";
							echo "<td>".$row["time_out"]."</td>";
							echo "<td>". $wd = $row["work_check"]."</td>";
								$TotalWorkDay += $wd;
							echo "<td>". $wd = (($row["work_extra_check"]==0)?"":$row["work_extra_check"])."</td>";
								$TotalWorkDay += $wd;
							echo "<td>".(($row["special"]==0)?"":$row["special"])."</td>";
							echo "<td>".$row["remark"]."</td>";
							
							echo "</tr>"."</form>";
							$printRow=1;
						}
					}
				}
				if (!$printRow) {
					echo "<tr>";
							
					echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
					echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))."</td>";
						
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
				$HLDcolor = "#FFFFFF" ;
				$DayColor = "#FFFFFF";
				$wd=0;
//				$is_holiday=0;
//				$is_holiday_week=0;
//				$remark="";
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
				<td colspan="3">  </td>
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
//echo "<br/>".$TotalAllowance;
?>
<br/>
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
<?php 
$dbObj->J_Close();
//$dbObj2
?>
</html>