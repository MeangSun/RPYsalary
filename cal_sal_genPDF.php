<?php
define('FPDF_FONTPATH','pdf/font/');
require('pdf/fpdf.php');

$month = $_GET['month'];
$emp_id = $_GET['emp_id'];
 
$pdf=new FPDF( 'P' , 'mm' , 'A4' );
$pdf->SetMargins( 1,3,2 );

$pdf->AddFont('cordia','','cordia.php');
$pdf->AddPage();
$pdf->SetFont('cordia','',20);


//$pdf->Text( 10 , 10 , iconv( 'UTF-8','cp874' , 'ทดสอบบ กีก่งปูกูกินกั้ง'));
//MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])


// พิมพ์ข้อความลงเอกสาร 
$pdf->Cell( 0  , 10 , iconv( 'UTF-8','cp874' , 'เงินเดือนพนักงาน เดือน'.$month ) , 0 , 1 , 'C' );
 
// พิมพ์ข้อความลงเอกสาร  มีกรอบด้วย
$pdf->Cell( 40  , 8 , iconv( 'UTF-8','cp874' , "ชื่อ : ".$emp_id ) , 0 );

$pdf->Ln();

$pdf->SetXY(1, 20);

$pdf->SetFont('cordia','',16);
$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วันที่' )  , 1,0,'C');
$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วัน' )  , 1,0,'C');
$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาเข้า' )  , 1,0,'C');
$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาออก' )  , 1,0,'C');
$pdf->SetFont('cordia','',12);
$pdf->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , 'ทำงาน' )  , 1,0,'C');
$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , 'พิเศษ' )  , 1,0,'C');
$pdf->SetFont('cordia','',16);
$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
$pdf->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , 'หมายเหตุ' )  , 1,0,'C');

$pdf->Cell( 2 , 8 ,iconv( 'UTF-8','cp874' , ' ' )  , 0,0,'C');

$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วันที่' )  , 1,0,'C');
$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , 'วัน' )  , 1,0,'C');
$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาเข้า' )  , 1,0,'C');
$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , 'เวลาออก' )  , 1,0,'C');
$pdf->SetFont('cordia','',12);
$pdf->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , 'ทำงาน' )  , 1,0,'C');
$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , 'พิเศษ' )  , 1,0,'C');
$pdf->SetFont('cordia','',16);
$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
$pdf->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , 'หมายเหตุ' )  , 1,0,'C');

$pdf->Ln();
for ($i = 1; $i <=31; $i++) {
	if ($i<17) {
		$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C');
		$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Ln();
	}
	else {
		$pdf->SetXY(106, 28+(($i-17)*8));
		$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , $i)  , 1,0,'C');
		$pdf->Cell( 8  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 15  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9  , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 9 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
		$pdf->Cell( 30 , 8 ,iconv( 'UTF-8','cp874' , '' )  , 1,0,'C');
	}
}
$pdf->SetXY(106, 148);
$pdf->Cell( 46  , 8 ,iconv( 'UTF-8','cp874' , 'รวม')  , 1,0,'C');
$pdf->Cell( 18  , 8 ,iconv( 'UTF-8','cp874' , '')  , 1,0,'C');
$pdf->Cell( 39  , 8 ,iconv( 'UTF-8','cp874' , '')  , 1,0,'C');




function header_tbl() {
	
$pdf->Ln();
}$pdf->Output();
?>
