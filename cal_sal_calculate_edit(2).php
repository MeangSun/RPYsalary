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
//$remark="";
//
$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $row) {
		$double_day_week=$row["double_day_week"];
		$holiday_week=$row["holiday_week"];
		$emp_type=$row["emp_type"];
		$emp_name=$row["emp_name"];
		$wage_per_day = $row["wage_per_day"];
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
echo "ชื่อ : ". $emp_name ." เดือน : ".$month;
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
				<td width="35 px"></td>
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
										<td width=\"35 px\"></td>
						
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
							echo "<form action=\"cal_sal_calculate_update.php\" method=\"POST\">"."<tr>";
							
							echo "<input type=\"hidden\" name=\"emp_id\" value=\"".$emp_id."\" />";
							echo "<input type=\"hidden\" name=\"month\" value=\"".$month."\" />";
							echo "<input type=\"hidden\" name=\"id\" value=\"".$row["id"]."\" />";
							
							echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
							echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))."</td>";
							echo "<td>"."<input type=\"text\" name=\"time_in\" value=\"".$row["time_in"]."\" size=\"5\"/>"."</td>";
							echo "<td>"."<input type=\"text\" name=\"time_out\" value=\"".$row["time_out"]."\"  size=\"5\"/>"."</td>";
							echo "<td><select name=\"work_check\">";	
									switch ($row["work_check"]) {
										case 0:
											echo "<option value=\"0\" selected>0</option><option value=\"0.5\">0.5</option><option value=\"1\">1</option>";
										break;
										case 0.5:
											echo "<option value=\"0\">0</option><option value=\"0.5\" selected>0.5</option><option value=\"1\">1</option>";
										break;
										case 1:
											echo "<option value=\"0\">0</option><option value=\"0.5\">0.5</option><option value=\"1\" selected>1</option>";
										break;
									}
									$TotalWorkDay += $row["work_check"];
							echo "</select></td>";
								
							echo "<td><select name=\"work_extra_check\">";	
									switch ($row["work_extra_check"]) {
										case 0:
											echo "<option value=\"0\" selected>0</option><option value=\"0.5\">0.5</option><option value=\"1\">1</option>";
										break;
										case 0.5:
											echo "<option value=\"0\">0</option><option value=\"0.5\" selected>0.5</option><option value=\"1\">1</option>";
										break;
										case 1:
											echo "<option value=\"0\">0</option><option value=\"0.5\">0.5</option><option value=\"1\" selected>1</option>";
										break;
									}
									$TotalWorkDay += $row["work_extra_check"];
							echo "</select></td>";
							
							echo "</td>";
							echo "<td>"."<input type=\"text\" name=\"special\" value=\"".$row["special"]."\"  size=\"5\"/>"."</td>";
							echo "<td>"."<input type=\"text\" name=\"remark\" value=\"".$row["remark"]."\"  size=\"35\"/>"."</td>";
							echo "<td>"."<input type=\"submit\" value=\"Update\" />"."</td>";
							
							echo "</tr>"."</form>";
							$printRow=1;
						}
					}
				}
				if (!$printRow) {
					echo "<form action=\"cal_sal_calculate_insert.php\" method=\"POST\">"."<tr>";
					echo "<input type=\"hidden\" name=\"emp_id\" value=\"".$emp_id."\" />";
					echo "<input type=\"hidden\" name=\"month\" value=\"".$month."\" />";
					echo "<input type=\"hidden\" name=\"date\" value=\"".$i."\" />";
					
					echo "<td bgcolor=\"$HLDcolor\">".$i."</td>";
					echo "<td bgcolor=\"$DayColor\">". getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4))))."</td>";
					//							echo "<td bgcolor=\"$HLDcolor\">"."</td>";
					//							echo "<td bgcolor=\"$DayColor\">"."</td>";
					echo "<td>"."<input type=\"text\" name=\"time_in\" size=\"5\"/>"."</td>";
					echo "<td>"."<input type=\"text\" name=\"time_out\" size=\"5\"/>"."</td>";
					echo "<td><select name=\"work_check\">".
							"<option value=\"\" selected></option>
							<option value=\"0\">0</option>
							<option value=\"0.5\">0.5</option>
							<option value=\"1\">1</option>".
						"</select></td>";
					echo "<td><select name=\"work_extra_check\">".
							"<option value=\"\" selected></option>
							<option value=\"0\">0</option>
							<option value=\"0.5\">0.5</option>
							<option value=\"1\">1</option>".
						"</select></td>";
					echo "<td>"."<input type=\"text\" name=\"special\" size=\"5\"/>"."</td>";
					echo "<td>"."<input type=\"text\" name=\"remark\" size=\"35\"/>"."</td>";
					echo "<td>"."<input type=\"submit\" value=\"Insert Row\" />"."</td>";
						
					echo "</tr>"."</form>";
				}
				$printRow=0;
				$date=$i;
				$HLDcolor = "#FFFFFF" ;
				$DayColor = "#FFFFFF";
				$is_holiday=0;
				$is_holiday_week=0;
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

<table>
<tr>
	<td>
	</td>
	<td>
		<table id="table-f">
			<tr width="200px">
				<td><?php echo $TotalWorkDay." x ".$wage_per_day;?></td><td>  <?php echo $TotalWorkDay*$wage_per_day?></td> 
					
				
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
//function checkWorking($in,$out) {
//	list($in_h,$in_m) = split(':', $in);
//	list($out_h,$out_m) = split(':', $out);
//	
//	if ($in == "" && $out =="") {
//		return 0;
//	}
//	elseif ($in == "" || $out =="") {
//		return 0.5;
//	}
//	elseif ($out_h-$in_h < 8) {
//		return 0.5;
//	}
//	else return 1;
//}
//function getAllowance($type,$in,$check) {
//	if ($in=="" || $check==0.5) {
//		return "";
//	}
//	
//	list($in_h,$in_m) = split(':', $in);
//	
//	$time_in = ($in_h*60)+$in_m;
//	
//	if ($type==1) {
//		if ($time_in<=510) {
//			return 70;
//		}
//		elseif ($time_in>510 && $time_in<=570) {
//			return 50;
//		}
//		else return 30;
//	}
//	elseif ($type==2){
//		if ($time_in<=480) {
//			return 20;
//		}
//		elseif ($time_in>510) {
//			return -30;
//		}
//	}
//	elseif ($type==4) {
//		if ($time_in>480 && $time_in<=510) {
//			return -20;
//		}
//		elseif ($time_in>510) {
//			return -40;
//		}
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
//
//$fieldName = "id";
//$tableName = "employee_status WHERE emp_id=".$emp_id." AND month=".$month;
//
//$result = $dbObj2->J_Select($fieldName,$tableName);
//if(count($result) > 0){
//	foreach($result as $read)
//	{
//		$status_id = $read["id"];
//		$ins["id"]=$status_id;
//		$ins["status"]="4";
//		$key=array(0);
//		$dbObj2->J_Update($ins,$key,"employee_status");
//	}
//}
//
//print_r($holiday);
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