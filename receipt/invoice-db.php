<?php
session_start();
require('fpdf17/fpdf.php');
require "../Config.php";

if(isset($_GET['pay']))
{
    //select * from all table je , pastu output kat setiap kotak yg diperlukan //
    $pay_id=$_GET['pay'];
    //select rental id from payment
    $sql = "SELECT * FROM payment WHERE pay_id='$pay_id'";
    $result = mysqli_query($conn ,$sql);
    $row = mysqli_fetch_array($result);
        $p_rental_id=$row['rental_id']; 
        

    $sql2 = "SELECT * FROM rental r WHERE rental_id='$p_rental_id'";
    $result2 = mysqli_query($conn ,$sql2);
    $row2 = mysqli_fetch_array($result2);
    $car_id=$row2['car_id'];

    $username=$_SESSION['username'];
    $sql3="SELECT * FROM customer WHERE users_id=(SELECT users_id FROM users WHERE username='$username')";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_array($result3);

    $sql4="SELECT * FROM car WHERE car_id='$car_id'";
    $result4 = mysqli_query($conn, $sql4);
    $row4 = mysqli_fetch_array($result4);

            
//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'Azure Car Rental SDN BHD',0,0);
$pdf->Cell(59	,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'Lot 10123, Jalan TU 43,',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line
$pdf->Cell(130	,5,'Kawasan Perindustrian Ayer Keroh',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'75450 Ayer Keroh, Melaka',0,0);
$pdf->Cell(25	,5,'Date',0,0);
$pdf->Cell(34	,5,$row['pay_date'],0,1);//end of line

$pdf->Cell(130	,5,'06-231 4133',0,0);
$pdf->Cell(25	,5,'Pay ID ',0,0);
$pdf->Cell(34	,5,$_GET['pay'],0,1);//end of line

$pdf->Cell(130	,5,'carrental@gmail.com',0,0);
$pdf->Cell(25	,5,'Rental ID',0,0);
$pdf->Cell(34	,5,$row['rental_id'],0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address
$pdf->Cell(100	,5,'Bill to :',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,$row3['cust_name'],0,1);
$pdf->Cell(10	,5,'',0,0);
$pdf->Cell(90	,5,$row3['email'],0,1);

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130	,5,'Car Details',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(189	,10,'',0,1);//end of line


$pdf->Cell(110	,5,'Plate No',1,0);
$pdf->Cell(70	,5,$row4['plate_no'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Model',1,0);
$pdf->Cell(70	,5,$row4['model'],1,1,'R');//end of line
$pdf->Cell(110	,5,'No Of Seat',1,0);
$pdf->Cell(70	,5,$row4['no_of_seat'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Transmission',1,0);
$pdf->Cell(70	,5,$row4['transmission'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Car Condition',1,0);
$pdf->Cell(70	,5,$row4['car_condition'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Rate Per Hour',1,0);
$pdf->Cell(70	,5,'RM '.$row4['rate_hour'],1,1,'R');//end of line

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130	,5,'Rental Details',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(189	,10,'',0,1);//end of line


$pdf->Cell(110	,5,'Start Time',1,0);
$pdf->Cell(70	,5,$row2['start_time'],1,1,'R');//end of line
$pdf->Cell(110	,5,'End Time',1,0);
$pdf->Cell(70	,5,$row2['end_time'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Duration',1,0);
$pdf->Cell(70	,5,$row2['duration'],1,1,'R');//end of line
$pdf->Cell(110	,5,'Contractual Duration',1,0);
$pdf->Cell(70	,5,$row2['contractual_duration'].' hour(s)',1,1,'R');//end of line

$pdf->Cell(189	,10,'',0,1);//end of line

$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130	,5,'Payment Details',0,0);
$pdf->SetFont('Arial','',12);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(189	,10,'',0,1);//end of line
$pdf->Cell(110	,5,'Description',1,0);
$pdf->Cell(70	,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);

	$pdf->Cell(110	,5,'Actual Price',1,0);
    $pdf->Cell(70	,5,'RM '.$row['actual_price'],1,1,'R');//end of line
    $pdf->Cell(110	,5,'Overdue Charges',1,0);
    $pdf->Cell(70	,5,'RM '.$row['overdue_charge'],1,1,'R');//end of line
    $pdf->Cell(110	,5,'Subtotal',0,0);
$pdf->Cell(70	,5,'RM '.$row['total_price'],1,1,'R');//end of line

$pdf->Output();

}
?>