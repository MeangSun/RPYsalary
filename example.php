<?php
  require ('pdf/fpdf_thai.php');
 
 $w = array(12, 105,20);

class PDF extends FPDF_Thai
{
	function Header()
	{	 
		global  $w;
   				
		$this->SetFillColor(255,255,255);
		
		$this->Ln();
		$this->SetFont('LilyUPC','',30);
		$this->Cell(16, 5, '√È“π¢π¡Õ√ËÕ¬‡®È“‡°Ë“',0, 0,'L');
		$this->SetFont('LilyUPC','',20);
		$this->Cell(80, 5, '',0, 0,'L');		
		
		$this->SetFont('AngsanaNew','',14);
		//$this->SetXY(array_sum($w),5);
		$this->Cell(35, 5, 'ÀπÈ“∑’Ë ',0, 0,'R');
		$this->SetFont('AngsanaNew','B',14);
		$this->Cell(10, 5, $this->PageNo(),0, 0,'L');		
		
	
		$this->Ln();
		$this->SetFont('LilyUPC','B',22);
		$this->Cell(140, 7, '„∫«“ß∫‘≈',0, 0,'C');			
		
 		$this->Ln(); 
 		
 		$this->SetFont('AngsanaNew','B',16);
		$this->Cell(12, 9, '≈Ÿ°§È“ : ',0, 0,'L');			
		$this->Cell(125, 9, 'ÀÈ“ß·¡§‚§√  “¢“∫“ß„®',0, 0,'L');			
		$this->Ln(); 
		
		$this->SetFont('AngsanaNew','',16);
		//Header
		$header = array('≈”¥—∫', '√“¬°“√', '®”π«π');
 		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],10,$header[$i],1,0,'C',1);

		$this->Ln();	
	}
  		
	function BillDetail( )
	{
		$this->Cell( 0  , 10 , iconv( 'UTF-8','cp874' , 'พิมพ์ให้อยู่ตรงกลาง' ) , 1 , 1 , 'C' );
		
 	}
}


	$pdf = new PDF ( );
	$pdf->AliasNbPages();
	$pdf->SetMargins(5, 5);
	$pdf->AddFont ( 'AngsanaNew', '', 'angsa.php' );
	$pdf->AddFont ( 'AngsanaNew', 'B', 'angsab.php' );
	$pdf->AddFont ( 'LilyUPC', '', 'upcll.php' );
	$pdf->AddFont ( 'LilyUPC', 'B', 'upclb.php' );
	$pdf->AddPage ();
	$pdf->SetFont ( 'AngsanaNew', '', 14);

	//Output table
	$pdf->BillDetail ();
 		
	$pdf->Output ();

?>