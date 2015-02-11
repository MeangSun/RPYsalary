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

$dbObj2 = new J_SQL;
$dbObj2->J_ConnectDB();
$dbObj2->J_SelectDB();
$dbObj2->set_char_utf8();


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
$remark="";

$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $row) {
		$double_day_week=$row["double_day_week"];
		$holiday_week=$row["holiday_week"];
		$emp_type=$row["emp_type"];
	}
}
$is_double=0;
$TotalAllowance=0;

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
						$remark = $holiday[$j]["remark"];
						$HLDcolor ="#CCFF99"; 
						$is_holiday=1;
					}
				}
				
				
				
				if($double_day_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))
				{
					$is_double=1;
					$DayColor="#CCFF99"; 
				}
				elseif($holiday_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))
				{
					$is_holiday_week=1;
					$DayColor="#CCFF99"; 
				}
				
				if(count($result) > 0){
					foreach($result as $row)
					{
						$ins2["id"]=$row["id"];
						$key=array(0);
						if ($i==$row["date"]) {
							echo "<tr>";
							
							echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
							echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
							echo "<td>".$row["time_in"]."</td>";
							echo "<td>".$row["time_out"]."</td>";
							echo "<td>". checkWorking($row["time_in"], $row["time_out"])."</td>";
								$ins2["work_check"]=checkWorking($row["time_in"], $row["time_out"]);
								$TotalWorkDay += checkWorking($row["time_in"], $row["time_out"]);
							echo "<td>";
								if ($is_holiday==1){
									echo 1;
									$ins2["work_extra_check"]=1;
									$TotalWorkDay += 1;
								}
								/*elseif ($is_holiday_week==1 && $emp_type!=4) {
									echo 1;
									$ins2["work_extra_check"]=1;
									$TotalWorkDay += 1;
								}
								elseif ($double_day_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) {
									echo checkWorking($row["time_in"], $row["time_out"]);
									$ins2["work_extra_check"]=checkWorking($row["time_in"], $row["time_out"]);
									$TotalWorkDay += checkWorking($row["time_in"], $row["time_out"]);
								}*/
								elseif ($double_day_week!=date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) {
									echo "";
									$ins2["work_extra_check"]="";
								}
							echo "</td>";
							echo "<td>".getAllowance($emp_type,$row["time_in"],checkWorking($row["time_in"], $row["time_out"]))."</td>";
								$ins2["special"]=getAllowance($emp_type,$row["time_in"],checkWorking($row["time_in"], $row["time_out"]));
								$TotalAllowance += getAllowance($emp_type,$row["time_in"],checkWorking($row["time_in"], $row["time_out"]));
							echo "<td>".$remark."</td>";
								$ins2["remark"]=$remark;
							
							echo "</tr>";
							$dbObj2->J_Update($ins2, $key, "work");
							$printRow=1;
						}
					}
				}
				if (!$printRow) {
					echo "<tr>";
							
					echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
						$ins3["date"]=$i;
					echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) ."</td>";
					echo "<td>"."</td>";
					echo "<td>"."</td>";
					echo "<td> 0 </td>";
						$ins3["work_check"]=0;
					echo "<td>";
						if ($is_holiday==1) {
							echo 1;
							$ins3["work_extra_check"]=1;
							$TotalWorkDay += 1;
						}
						/*elseif ($is_holiday_week==1) {
							echo 1;
							$ins3["work_extra_check"]=1;
							$TotalWorkDay += 1;
						}
						elseif ($double_day_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) {
							echo 0;
							$ins3["work_extra_check"]=0;
						}*/
						else $ins3["work_extra_check"]=0;
					echo "</td>";
					echo "<td>"."</td>";
						$ins3["special"]="";
					echo "<td>".$remark."</td>";
						$ins3["remark"]=$remark;		
					
					echo "</tr>";
					if ($ins3["work_extra_check"]==1) {
						$ins3["emp_id"]=$emp_id;
						$ins3["month"]=$month;
						$dbObj2->J_Insert($ins3, "work");
					}
					
				}
				$printRow=0;
				$date=$i;
				$HLDcolor = "#FFFFFF" ;
				$DayColor = "#FFFFFF";
				$is_holiday=0;
				$is_holiday_week=0;
				$remark="";
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
	list($in_h,$in_m) = split(':', $in);
	list($out_h,$out_m) = split(':', $out);
	
	if ($in == "" && $out =="") {
		return 0;
	}
	elseif ($in == "" || $out =="") {
		return 0.5;
	}
	elseif ($out_h-$in_h < 8) {
		return 0.5;
	}
	else return 1;
}
function getAllowance($type,$in,$check) {
	if ($in=="" || $check==0.5) {
		return "";
	}
	
	list($in_h,$in_m) = split(':', $in);
	
	$time_in = ($in_h*60)+$in_m;
	
	if ($type==1) {
		if ($time_in>570) {
			return -50;
		}
	}
	elseif ($type==2){
		if ($time_in<=480) {
			return 20;
		}
		elseif ($time_in>510) {
			return -30;
		}
	}
	elseif ($type==4) {
		if ($time_in>510 && $time_in<=540) {
			return -30;
		}
		elseif ($time_in>540) {
			return -60;
		}
	}
}
//function checkIsExtraWorking($week_date,$h_week,$d_week,$wage) {
//	if ($h_week=="" && $d_week=="") {
//		return "";
//	}
//}


//function isHoliday($i) {
//	for ($j = 0; $j < $numHoliday; $j++) {
//		if($i==$holiday[$j]){
//			return 1;
//		}
//	}
//	return 0;
//}

$fieldName = "id";
$tableName = "employee_status WHERE emp_id=".$emp_id." AND month=".$month;

$result = $dbObj2->J_Select($fieldName,$tableName);
if(count($result) > 0){
	foreach($result as $read)
	{
		$status_id = $read["id"];
		$ins["id"]=$status_id;
		$ins["status"]="4";
		$key=array(0);
		$dbObj2->J_Update($ins,$key,"employee_status");
	}
}

print_r($holiday);
echo "<br/>".$TotalAllowance;
?>
<br/>
<form id="centering"> 
<INPUT TYPE="button" id="button1" VALUE=" Back " onClick="parent.location='cal_sal_emp_detail.php?emp_id=<?php echo $emp_id?>&month=<?php echo $month?>'">
</form>
</body>
<?php 
$dbObj->J_Close();
$dbObj2->J_Close();
?>
</html>