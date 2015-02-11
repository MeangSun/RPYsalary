<?php
date_default_timezone_set('Asia/Bangkok');
define('FPDF_FONTPATH','pdf/font/');
require('pdf/fpdf.php');

include("database/config.php");
include("database/J_MySQL.php");

$dbObj = new J_SQL;
$dbObj->J_ConnectDB();
$dbObj->J_SelectDB();
$dbObj->set_char_utf8();

$month = $_GET['month'];
$emp_id = $_GET['emp_id'];

$TotalWork=0;
$TotalExtra=0;
$TotalWorkExtra=0;
$Type4Late30=0;
$Type4Late60=0;
$Type1Late50=0;
$Type2early20=0;
$Type2late30=0;
$Type1Allowance;

$fieldNames ="*";
$tableName ="holiday WHERE month = ".$month. " ORDER BY date";
$result = $dbObj->J_Select($fieldNames, $tableName);

$numHoliday=0;
if(count($result) > 0) {
	foreach($result as $row) {
		$holiday[$numHoliday]["date"]=$row["date"];
		$numHoliday++;
	}
}

$tableName ="employee WHERE emp_id = ".$emp_id;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $row) {
		$EMP_NAME = $row["emp_name"];
		$EMP_TYPE = $row["emp_type"];
		$WAGE_PER_DAY = $row["wage_per_day"];
		$WAGE_PER_MONTH = $row["wage_per_month"];
		$WAGE_EXTRA = $row["wage_extra"];
		$SOCIAL_SECURITY = $row["social_security"];
		$DIS_WAGE_PER_DAY = $row["dis_wage_per_day"];
		$DIS_EXTRA_PER_DAY = $row["dis_extra_per_day"];
		$COUNT_HOLIDAY = $row["count_holiday"];
		$HOLIDAY_WEEK = $row["holiday_week"];
		$DOUBLE_DAY_WEEK = $row["double_day_week"];
		$TELEPHONE = $row["telephone"];
		$REMARK = $row["remark"];
	}
}

$tableName ="month_employee WHERE emp_id = ".$emp_id." AND month = ".$month;
$result = $dbObj->J_Select($fieldNames, $tableName);

if(count($result) > 0) {
	foreach($result as $row) {
		$WITHDRAW10 = $row["withdraw10"];
		$WITHDRAW20 = $row["withdraw20"];
		$COMMISSION = $row["commission"];
		$DELIVERY = $row["delivery"];
		$NOT_WORK = $row["not_work"];
		$ETC_TXT = $row["etc_txt"];
		$ETC = $row["etc"];
	}
}

$tableName ="work WHERE emp_id = ".$emp_id." AND month = ".$month." ORDER BY date";
$result = $dbObj->J_Select($fieldNames, $tableName);


$numDaysInMonth = date("t", mktime(0, 0, 0, substr($month, 0, 2), 1, substr($month, -4)));

class PDF extends FPDF {
	function header_tbl() {
		$this->SetXY(1, 23);
		$this->SetFont('cordia','',16);
		$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วันที่' )  , 1,0,'C');
		$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วัน' )  , 1,0,'C');
		$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาเข้า' )  , 1,0,'C');
		$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาออก' )  , 1,0,'C');
		$this->SetFont('cordia','',12);
		$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , 'ทำงาน' )  , 1,0,'C');
		$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , 'พิเศษ' )  , 1,0,'C');
		$this->SetFont('cordia','',16);
		$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , 'หมายเหตุ' )  , 1,0,'C');

		$this->Cell( 2 , 8 ,iconv( 'UTF-8','cp874' , ' ' )  , 0,0,'C');

		$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วันที่' )  , 1,0,'C');
		$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วัน' )  , 1,0,'C');
		$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาเข้า' )  , 1,0,'C');
		$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาออก' )  , 1,0,'C');
		$this->SetFont('cordia','',12);
		$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , 'ทำงาน' )  , 1,0,'C');
		$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , 'พิเศษ' )  , 1,0,'C');
		$this->SetFont('cordia','',16);
		$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , 'หมายเหตุ' )  , 1,0,'C');
		
	}
	function body_tbl() {
		global $month;
		global $emp_id;
		global $result;
		global $holiday;
		global $numHoliday;
		
		global $EMP_TYPE;
		global $HOLIDAY_WEEK;
		global $DOUBLE_DAY_WEEK;
		
		global $numDaysInMonth;
		global $TotalWork;
		global $TotalExtra;
		global $TotalWorkExtra;
		global $Type4Late30;
		global $Type4Late60;
		global $Type1Late50;
		global $Type2early20;
		global $Type2late30;
		global $Type1Allowance;
		
		
		$printRow=0;
		for ($i = 1; $i <= $numDaysInMonth ; $i++) {
			if(count($result) > 0){
				foreach($result as $row) {
					if ($i==$row["date"]) {
						if ($i<17) {
							if (getHolidayColor($i, $holiday, $numHoliday)) {
								$this->SetFillColor(230, 230, 230);
							}
							else $this->SetFillColor(255, 255, 255);
							$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C',true);
							$this->SetFillColor(255, 255, 255);
							
							if (getDoubleHolidayWeekColor($i, $month, $HOLIDAY_WEEK, $DOUBLE_DAY_WEEK)) {
								$this->SetFillColor(230, 230, 230);
							}
							else $this->SetFillColor(255, 255, 255);
							$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) )  , 1,0,'C',true);
							$this->SetFillColor(255, 255, 255);
							
							$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , $row["time_in"] )  , 1,0,'C');
							$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , $row["time_out"] )  , 1,0,'C');
							$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , $row["work_check"] )  , 1,0,'C');
								$TotalWork += $row["work_check"];
							$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , ($row["work_extra_check"]==0)?"":$row["work_extra_check"] )  , 1,0,'C');
								$TotalExtra += $row["work_extra_check"];
							$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , ($row["special"]==0)?"":$row["special"] )  , 1,0,'C');
								if ($EMP_TYPE==1) {
									if ($row["special"]==-50) {
										$Type1Late50++;
									}
								}
								elseif ($EMP_TYPE==2) {
									if ($row["special"]==20) {
										$Type2early20++;
									}
									if ($row["special"]==-30) {
										$Type2late30++;
									}
								}
								elseif ($EMP_TYPE==4) {
									if ($row["special"]==-30) {
										$Type4Late30++;
									}
									if ($row["special"]==-60) {
										$Type4Late60++;
									}
								}
							$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , $row["remark"] )  , 1,0,'C');
							$this->Ln();
							$printRow=1;
						}
						else {
							$this->SetXY(106, 31+(($i-17)*8));
							if (getHolidayColor($i, $holiday, $numHoliday)) {
								$this->SetFillColor(230, 230, 230);
							}
							else $this->SetFillColor(255, 255, 255);
							$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C',true);
							$this->SetFillColor(255, 255, 255);
							
							if (getDoubleHolidayWeekColor($i, $month, $HOLIDAY_WEEK, $DOUBLE_DAY_WEEK)) {
								$this->SetFillColor(230, 230, 230);
							}
							else $this->SetFillColor(255, 255, 255);
							$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) )  , 1,0,'C',true);
							$this->SetFillColor(255, 255, 255);
					
							$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , $row["time_in"] )  , 1,0,'C');
							$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , $row["time_out"] )  , 1,0,'C');
							$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , $row["work_check"] )  , 1,0,'C');
								$TotalWork += $row["work_check"];
							$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , ($row["work_extra_check"]==0)?"":$row["work_extra_check"] )  , 1,0,'C');
								$TotalExtra += $row["work_extra_check"];
							$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , ($row["special"]==0)?"":$row["special"] )  , 1,0,'C');
								if ($EMP_TYPE==1) {
									if ($row["special"]==-50) {
										$Type1Late50++;
									}
								}
								elseif ($EMP_TYPE==2) {
									if ($row["special"]==20) {
										$Type2early20++;
									}
									if ($row["special"]==-30) {
										$Type2late30++;
									}
								}
								elseif ($EMP_TYPE==4) {
									if ($row["special"]==-30) {
										$Type4Late30++;
									}
									if ($row["special"]==-60) {
										$Type4Late60++;
									}
								}
							$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , $row["remark"] )  , 1,0,'C');
							$printRow=1;
						}
					}	
				}
			}
			if(!$printRow) {
				if ($i<17) {
					if (getHolidayColor($i, $holiday, $numHoliday)) {
						$this->SetFillColor(230, 230, 230);
					}
					else $this->SetFillColor(255, 255, 255);
					$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C',true);
					$this->SetFillColor(255, 255, 255);
					
					if (getDoubleHolidayWeekColor($i, $month, $HOLIDAY_WEEK, $DOUBLE_DAY_WEEK)) {
						$this->SetFillColor(230, 230, 230);
					}
					else $this->SetFillColor(255, 255, 255);
					$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) )  , 1,0,'C',true);
					$this->SetFillColor(255, 255, 255);
					
					$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , '0' )  , 1,0,'C');
					$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Ln();
				}
				else {
					$this->SetXY(106, 31+(($i-17)*8));
					if (getHolidayColor($i, $holiday, $numHoliday)) {
						$this->SetFillColor(230, 230, 230);
					}
					else $this->SetFillColor(255, 255, 255);
					$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C',true);
					$this->SetFillColor(255, 255, 255);
					
					if (getDoubleHolidayWeekColor($i, $month, $HOLIDAY_WEEK, $DOUBLE_DAY_WEEK)) {
						$this->SetFillColor(230, 230, 230);
					}
					else $this->SetFillColor(255, 255, 255);
					$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , getThDateWeek(date("N", mktime(0, 0, 0, substr($month, 0, 2), $i, substr($month, -4)))) )  , 1,0,'C',true);
					$this->SetFillColor(255, 255, 255);
					
					$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , '0' )  , 1,0,'C');
					$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
					$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				}
			}
			
			$printRow=0;
			$date=$i;
		}
		for ($j = $date+1; $j <= 31; $j++) {
				$this->SetXY(106, 31+(($j-17)*8));
				$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
				$this->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		}
		$TotalWorkExtra = $TotalWork + $TotalExtra;
		$this->SetXY(106, 151);
		$this->Cell( 46  , 8 ,iconv( 'UTF-8','cp874' , 'รวม')  , 1,0,'C');
		$this->Cell( 18  , 8 ,iconv( 'UTF-8','cp874' , $TotalWorkExtra)  , 1,0,'C');
		$this->Cell( 39  , 8 ,iconv( 'UTF-8','cp874' , '')  , 1,0,'C');
	}
	function calculate() {
		global $EMP_TYPE;
		global $WAGE_PER_DAY;
		global $WAGE_PER_MONTH;
		global $WAGE_EXTRA;
		global $SOCIAL_SECURITY;
		global $DIS_WAGE_PER_DAY;
		global $DIS_EXTRA_PER_DAY;
		global $COUNT_HOLIDAY;
		global $HOLIDAY_WEEK;
		global $DOUBLE_DAY_WEEK;
		global $TELEPHONE;
		global $REMARK;
		
		global $WITHDRAW10;
		global $WITHDRAW20;
		global $COMMISSION;
		global $DELIVERY;
		global $NOT_WORK;
		global $ETC_TXT;
		global $ETC;
		
		global $numDaysInMonth;
		global $TotalWork;
		global $TotalExtra;
		global $TotalWorkExtra;
		global $Type4Late30;
		global $Type4Late60;
		global $Type1Late50;
		global $Type2early20;
		global $Type2late30;
		global $Type1Allowance;
		$i=0;
		
		$this->SetFont('cordia','',16);
		$this->SetXY(116, 165);
		if ($WAGE_PER_DAY != 0) {
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , 'ค่าแรงต่อวัน')  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , $WAGE_PER_DAY )  , 1,0,'R');
			
			$this->SetXY(116, 178);
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , $WAGE_PER_DAY."    x    ".$TotalWorkExtra)  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format($WAGE_PER_DAY*$TotalWorkExtra) )  , 1,0,'R');
		}
		elseif ($WAGE_PER_MONTH != 0){
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , 'ค่าแรงต่อเดือน')  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , $WAGE_PER_MONTH )  , 1,0,'R');
			
			$this->SetXY(116, 178);
			if ($numDaysInMonth-$TotalWorkExtra > $COUNT_HOLIDAY) {
				$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "หยุด  ".($numDaysInMonth-$TotalWorkExtra)."  วัน (".$WAGE_PER_MONTH." - (".(-1)*$DIS_WAGE_PER_DAY." x ".($numDaysInMonth-$TotalWorkExtra-$COUNT_HOLIDAY)."))" )  , 1,0,'C');
			}
			else $this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "หยุด  ".($numDaysInMonth-$TotalWorkExtra)."  วัน (".$WAGE_PER_MONTH." + (".(-1)*$DIS_WAGE_PER_DAY." x ".(-1)*($numDaysInMonth-$TotalWorkExtra-$COUNT_HOLIDAY)."))" )  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format(getWagePerMonth($WAGE_PER_MONTH, $numDaysInMonth-$TotalWorkExtra, $COUNT_HOLIDAY, $DIS_WAGE_PER_DAY, $EMP_TYPE)) )  , 1,0,'R');
		}
		
		if ($WAGE_EXTRA!=0) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "พิเศษ")  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format(getWageExtra($WAGE_EXTRA, $DIS_EXTRA_PER_DAY, $numDaysInMonth-$TotalWorkExtra, $COUNT_HOLIDAY)) )  , 1,0,'R');
			$i++;
		}
		$food=-500;
		if($EMP_TYPE!=5) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "ค่าอาหาร 500")  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format($food) )  , 1,0,'R');
			$i++;
		}
		else{
			$food=0;
		}
		if($EMP_TYPE==1) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "หักค่ามาสาย -50  x ".$Type1Late50)  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format(-1*($Type1Late50*50)) )  , 1,0,'R');
			$i++;
		}
		if($EMP_TYPE==4) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "หักค่ามาสาย (-30x".$Type4Late30.")+(-60x".$Type4Late60.")")  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format(-1*(($Type4Late30*30)+($Type4Late60*60))) )  , 1,0,'R');
			$i++;
		}
		
		if ($TELEPHONE!=0) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "ค่าโทรศัพท์")  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format($TELEPHONE) )  , 1,0,'R');
			$i++;
		}
		$this->SetXY(116, 186+(8*$i));
		$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "เบิกเงินวันที่ 10")  , 1,0,'C');
		$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , ($WITHDRAW10==0)?"":number_format($WITHDRAW10) )  , 1,0,'R');
		$i++;
		$this->SetXY(116, 186+(8*$i));
		$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "เบิกเงินวันที่ 20")  , 1,0,'C');
		$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , ($WITHDRAW20==0)?"":number_format($WITHDRAW20) )  , 1,0,'R');
		$i++;
		
		if ($SOCIAL_SECURITY!=0) {
			$this->SetXY(116, 186+(8*$i));
			$this->Cell( 60  , 8 ,iconv( 'UTF-8','cp874' , "หักค่าประกันสังคม")  , 1,0,'C');
			$this->Cell( 30  , 8 ,iconv( 'UTF-8','cp874' , number_format($SOCIAL_SECURITY) )  , 1,0,'R');
			$i++;
		}
		
		$TotalSalary = ($WAGE_PER_DAY*$TotalWorkExtra)
			+(getWagePerMonth($WAGE_PER_MONTH, $numDaysInMonth-$TotalWorkExtra, $COUNT_HOLIDAY, $DIS_WAGE_PER_DAY, $EMP_TYPE))
			+(getWageExtra($WAGE_EXTRA, $DIS_EXTRA_PER_DAY, $numDaysInMonth-$TotalWork, $COUNT_HOLIDAY))
			+($Type1Allowance)
			+(-1*(($Type4Late30*30)+($Type4Late60*60)))
			+(-1*($Type1Late50*50))
			+($TELEPHONE)
			+($food)
			+($WITHDRAW10)
			+($WITHDRAW20)
			+($SOCIAL_SECURITY);
			
		$this->SetFont('cordia','B',22);
		$this->SetXY(116, 186+(8*$i));
		$this->Cell( 60  , 10 ,iconv( 'UTF-8','cp874' , "คงเหลือ")  , 1,0,'C');
		$this->Cell( 30  , 10 ,iconv( 'UTF-8','cp874' , number_format($TotalSalary))  , 1,0,'R');
		
		////////////////////////////// 2 //////////////////////////////////////////
		
		$j=0;
		$this->SetFont('cordia','',16);
		
		if($EMP_TYPE==2) {
			$this->SetXY(15, 202+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , "มาเช้า   ".$Type2early20."   วัน")  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , $Type2early20*20 )  , 1,0,'R');
			$j++;
			$this->SetXY(15, 202+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , "มาสาย   ".$Type2late30."   วัน")  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , $Type2late30*(-30) )  , 1,0,'R');
			$j++;
		}
		if ($COMMISSION!=0) {
			$this->SetXY(15, 202+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , "คอมมิสชั่น")  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , number_format($COMMISSION) )  , 1,0,'R');
			$j++;
		}
		if ($DELIVERY!=0) {
			$this->SetXY(15, 202+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , "ค่าเที่ยว   ".$DELIVERY."  x  5")  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , $DELIVERY*5 )  , 1,0,'R');
			$j++;
		}
		if ($EMP_TYPE==2 || $EMP_TYPE==4) {
			$this->SetXY(15, 202+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , "หักค่าไม่มีใบลา")  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , $NOT_WORK )  , 1,0,'R');
			$j++;
		}
		if ($ETC_TXT!="" || $ETC!=0) {
			$this->SetXY(15, 194+(8*$j));
			$this->Cell( 50  , 8 ,iconv( 'UTF-8','cp874' , $ETC_TXT)  , 1,0,'C');
			$this->Cell( 20  , 8 ,iconv( 'UTF-8','cp874' , $ETC )  , 1,0,'R');
			$j++;
		}
		$TotalPayText = number_format(($TotalSalary))
			.(($Type2early20==0)?"":(" + ".number_format($Type2early20*20)))
			.(($Type2late30==0)?"":(" - ".number_format($Type2late30*(30))))
			.(($COMMISSION==0)?"":(" + ".number_format($COMMISSION)))
			.(($DELIVERY==0)?"":(" + ".number_format($DELIVERY*5)))
			.(($NOT_WORK==0)?"":(" - ".number_format($NOT_WORK*(-1))))
			.(($ETC==0)?"":(" + ".number_format($ETC)));
		
		$TotalPay=number_format($TotalSalary+($Type2early20*20)+($Type2late30*(-30))+$COMMISSION+($DELIVERY*5)+$NOT_WORK+$ETC);
		$this->SetFont('cordia','B',22);
		$this->SetXY(5,255);
		$this->Cell( 200  , 10 ,iconv( 'UTF-8','cp874' ,"*** ต้องจ่ายจริง   ".$TotalPayText." = ".$TotalPay)  , 1,0,'C');
		
		///////////////// remark /////////////////
		
		list($remark_arr[0], $remark_arr[1], $remark_arr[2], $remark_arr[3], $remark_arr[4], $remark_arr[5], ) = split("/n", $REMARK);
		$this->SetFont('cordia','',14);
		
		for ($j2 = 0; $j2 < 6; $j2++) {
			$this->SetXY(5, 163+($j2*6));
			$this->Cell( 100  , 6 ,iconv( 'UTF-8','cp874' ,$remark_arr[$j2])  , 0,0,'L');
		}
		
	}
}

 
$pdf=new PDF( 'P' , 'mm' , 'A4' );
$pdf->SetMargins( 1,3,2 );
$pdf->AddFont('cordia','','cordia.php');
$pdf->AddFont('cordia','B','cordiab.php');
$pdf->AddPage();
$pdf->SetFont('cordia','',22);

$pdf->Cell( 0  , 10 , iconv( 'UTF-8','cp874' , "เงินเดือนพนักงาน เดือน".getThMonth(substr($month, 0, 2))." พ.ศ.".(substr($month, -4)+543) ) , 0 , 1 , 'C' );
$pdf->Cell( 40  , 8 , iconv( 'UTF-8','cp874' , "ชื่อ : ".$EMP_NAME ) , 0 );

$pdf->Ln();
$pdf->header_tbl();

$pdf->Ln();
$pdf->body_tbl();
$pdf->calculate();

$pdf->Output();

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
function getThMonth($m) {
	switch ($m){
	case 01:
		return "มกราคม";
	case 02:
		return "กุมภาพันธ์";
	case 03:
		return "มีนาคม";
	case 04:
		return "เมษายน";
	case 05:
		return "พฤษภาคม";
	case 06:
		return "มิถุนายน";
	case 07:
		return "กรกฎาคม";
	case 08:
		return "สิงหาคม";
	case 09:
		return "กันยายน";
	case 10:
		return "ตุลาคม";
	case 11:
		return "พฤศจิกายน";
	case 12:
		return "ธันวาคม";
	}
	
}
function getWagePerMonth($wage_month ,$day_lost ,$count_holiday ,$dis_wage_per_day,$type ) {
	if ($type==3) {
		if($day_lost > $count_holiday) {
			return $wage_month - ($dis_wage_per_day*($day_lost-$count_holiday)*(-1));
		}
		elseif ($day_lost == $count_holiday) {
			return $wage_month;
		}
		elseif ($day_lost < $count_holiday) {
			return $wage_month + ($dis_wage_per_day*($count_holiday-$day_lost)*(-1));
		}
	}
	else return 0;
}
function getWageExtra($w_extra, $dis_extra_day, $diff_day, $count) {
	if ($w_extra>0) {
		if ($diff_day>$count) {
			return $w_extra+(($diff_day-$count)*$dis_extra_day);
		}
		return $w_extra;
	}
	else return 0;
}
function getHolidayColor($day ,$holiday_arr ,$numHoliday) {
	for ($i = 0; $i < $numHoliday; $i++) {
		if ($day == $holiday_arr[$i]["date"]) {
			return 1;
		}
	}
	return 0;
}
function getDoubleHolidayWeekColor($day ,$month ,$holiday_week ,$double_day_week) {
	if ($double_day_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $day, substr($month, -4))) || $holiday_week==date("N", mktime(0, 0, 0, substr($month, 0, 2), $day, substr($month, -4)))) {
		return 1;
	}
	else return 0;
}

$dbObj->J_Close();
?>
