<?php 
session_start();
require "Config.php";

    $username = $_SESSION["username"];
	$sql="SELECT * FROM customer WHERE users_id=(SELECT users_id FROM users WHERE username='$username')";

	if($result = mysqli_query($conn, $sql)){
    	if(mysqli_num_rows($result) > 0){
        	while($row = mysqli_fetch_array($result)){
                $cust_id=$row['cust_id'];
                $cust_name=$row['cust_name'];    
        	}
    	mysqli_free_result($result);
    	}
	}

	$sql = "SELECT * FROM rental WHERE cust_id='$cust_id'";
    $results = mysqli_query($conn, $sql); 

    while ($row = mysqli_fetch_array($results)) {
        $status = $row['status'];
        if($status == "Unpaid")
        {
            $rental_id = $row['rental_id'];
            $car_id = $row['car_id']; 
            $cust_id = $row['cust_id']; 
            $date = $row['date']; 
            $start_time = $row['start_time']; 
            $end_time = $row['end_time']; 
            $duration = $row['duration']; 
            $contractual_duration = $row['contractual_duration']; 
        }       
    
    }
    

    $sql="SELECT * FROM car WHERE car_id = '$car_id'";
	if($result = mysqli_query($conn, $sql)){
    	if(mysqli_num_rows($result) > 0){
        	while($row = mysqli_fetch_array($result)){
                $rate=$row['rate_hour'];
                $model = $row['model'];    
        	}
    	mysqli_free_result($result);
    	}
    }
    
    
    $days = (int)$duration;
    $daysToHours = $days * 24;
    if($daysToHours == 0) //total price , no overdue
    {
        $h = str_replace(" day(s),","",$duration);
        
        $ho = str_replace(" hour(s),","",$h);
        

        if($days == 0)
        {
            $hour = str_replace("0 day(s),","",$duration);
            
            $hours = (int)$hour;
        }
        else
        {
            if($days == 1)
            {
                $hour = str_replace("1 day(s),","",$duration);
            
                $hours = (int)$hour;
            }
            elseif($days == 2)
            {
                $hour = str_replace("2 day(s),","",$duration);
            
                $hours = (int)$hour;
            }
            elseif($days == 3)
            {
                $hour = str_replace("3 day(s),","",$duration);
            
                $hours = (int)$hour;
            }
            elseif($days == 4)
            {
                $hour = str_replace("4 day(s),","",$duration);
            
                $hours = (int)$hour;
            }
            elseif($days == 5)
            {
                $hour = str_replace("5 day(s),","",$duration);
            
                $hours = (int)$hour;
            }
            

        }

        $a = $hours * $rate;
    
        if($hours == 0){
            $minu = str_replace($hours,"",$ho);
            $minutes = str_replace(" minute(s)","",$minu);
            
            $b = ($minutes/60) *$rate;
            $total = $a + $b;
            $total=number_format((float)$total, 2, '.', '');
            $totalprice = $total;
            $minToHour = ($minutes/60);
        }
        //with hours and minutes
        else{
            if($hours==1)
            {
                $min = str_replace("01 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==2)
            {
                $min = str_replace("02 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==3)
            {
                $min = str_replace("03 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==4)
            {
                $min = str_replace("04 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==5)
            {
                $min = str_replace("05 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==6)
            {
                $min = str_replace("06 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==7)
            {
                $min = str_replace("07 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==8)
            {
                $min = str_replace("08 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==9)
            {
                $min = str_replace("09 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==10)
            {
                $min = str_replace("10 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==11)
            {
                $min = str_replace("11 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==12)
            {
                $min = str_replace("12 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==13)
            {
                $min = str_replace("13 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==14)
            {
                $min = str_replace("14 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==15)
            {
                $min = str_replace("15 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==16)
            {
                $min = str_replace("16 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==17)
            {
                $min = str_replace("17 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==18)
            {
                $min = str_replace("18 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==19)
            {
                $min = str_replace("19 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==20)
            {
                $min = str_replace("20 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==21)
            {
                $min = str_replace("21 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==22)
            {
                $min = str_replace("22 hour(s),","",$hour);
                $zero = (int)$min;
            }
            elseif($hours==23)
            {
                $min = str_replace("23 hour(s),","",$hour);
                $zero = (int)$min;
            }
            

            

            if($zero == 0)
            {   
                $mi = str_replace(" day(s),","",$min);
                $minu = str_replace(" hour(s),","",$mi);
                $minutt = str_replace(" ","0",$minu);
                $minut = str_replace("minute(s)","",$minutt);
                $minutt=$minut/10;
                $minutes = (int)$minutt;
                
                // $minutess = str_replace($minutes )
                $b = ($minutes/60) *$rate;
                $total = $a + $b;
                $total=number_format((float)$total, 2, '.', '');
                $totalprice = $total;
            }
            else{
                $mi = str_replace(" day(s),","",$min);
                $minu = str_replace(" hour(s),","",$mi);
                $minut = str_replace("minute(s)","",$minu);
                $minutes = (int)$minut;
                
                // $minutess = str_replace($minutes )
                $b = ($minutes/60) *$rate;
                $total = $a + $b;
                $total=number_format((float)$total, 2, '.', '');
                $totalprice = $total;
            }
        }
    
        //overdue range 0-59min xkira 
        $hours_overdue = $hours - $contractual_duration;
        if($hours_overdue > 0){
        $time_overdue = $minutes + ($hours_overdue*60);
        $over = $time_overdue/60 ;
        //overdue , RM20 per hour
        $overdue = ($over*20);
        $overdue = number_format((float)$overdue, 2, '.', '');
        $totalprice = $overdue + $total;
        }
        else{
            $overdue = 0;
        } 
    }
    else
    {
        $h = str_replace(" day(s),","",$duration);
        $j = str_replace($days,"",$h);
        $ho = (int)$j;
        
        $hours = $ho + $daysToHours;
        

        $a = $hours * $rate;
    
        if($hours == 0){
            $m = str_replace($ho,"",$j);

            $minu = str_replace(" hour(s),","",$m);
            $minutes = str_replace(" minute(s)","",$minu);
            $minutess = str_replace("00 ","",$minutes);
            $b = ($minutess/60) *$rate;
            $total = $a + $b;
            $total=number_format((float)$total, 2, '.', '');
            $totalprice = $total;
            $minToHour = ($minutess/60);
        }
        else{
            $min = str_replace($hours,"",$j);
            $zero = (int)$min;
            if($zero == 0)
            {   
                $minu = str_replace(" hour(s),","",$min);
                $minutt = str_replace(" ","0",$minu);
                $minut = str_replace("minute(s)","",$minutt);
                $minutt=$minut/10;
                $minutes = (int)$minutt;
            
                // $minutess = str_replace($minutes )
                $b = ($minutes/60) *$rate;
                $total = $a + $b;
                $total=number_format((float)$total, 2, '.', '');
                $totalprice = $total;
            }
            else{
                $minu = str_replace(" hour(s),","",$min);
                $minut = str_replace("minute(s)","",$minu);
                $minutes = (int)$minut;
            
                // $minutess = str_replace($minutes )
                $b = ($minutes/60) *$rate;
                $total = $a + $b;
                $total=number_format((float)$total, 2, '.', '');
                $totalprice = $total;
            }
        }

        //overdue range 0-59min xkira 
        $hours_overdue = $hours - $contractual_duration;
        if($hours_overdue > 0){
        $time_overdue = $minutes + ($hours_overdue*60);
        $over = $time_overdue/60 ;
        //overdue , RM20 per hour
        $overdue = ($over*20);
        $overdue = number_format((float)$overdue, 2, '.', '');
        $totalprice = $overdue + $total;
        }
        else{
            $overdue = 0;
        } 
    }


//submit payment details
if(isset($_POST['submit']))
{
    
    //proof of payment
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    
    if(in_array($fileActualExt, $allowed))
    {
        if($fileError === 0)
        {
            if($fileSize < 1000000){

                    
                        $pay_date = date("Y-m-d");
                        $file = addslashes(file_get_contents($fileTmpName));
                        $overdue = $_POST['overdue'];
                        $totalprice = $_POST['total_price'];
                        $totalprice = number_format((float)$totalprice, 2, '.', '');
                        $rental_id = $_POST['rental_id'];

                        $sql = "INSERT INTO payment(pay_date, actual_price, overdue_charge, total_price, rental_id, receipt) VALUES ('$pay_date', '$total', '$overdue', '$totalprice', '$rental_id', '$file')";
            
                        if(mysqli_query($conn, $sql)){
                            $status = "Paid";
                            $query = "UPDATE rental SET status='$status' WHERE cust_id='$cust_id'";
                            mysqli_query($conn, $query);    
                            echo "<script>alert('Payment successful ! Thank you for using Azure Car Rental !');window.location.href='index.php';</script>"; 
                        }
                        else{
                            $_SESSION['message2'] =  "Something went wrong. Please try again later.";
                            echo "<script>alert('Error occured ! Please try again !');window.location.href='Payment.php';</script>";
                        } 
                    
                
                }
            else
                {
                    $_SESSION['message_err4'] = "Your file size is too big!";
                    echo "<script>alert('File size too big ! Please try again !');window.location.href='Payment.php';</script>";
                }   
        }
        else
            {
                $_SESSION['message_err4'] = "There was an error uploading your file!";
                echo "<script>alert('Error occured ! Please try again !');window.location.href='Payment.php';</script>";
            }
    }
    else{
            $_SESSION['message_err4'] = "You cannot upload file of this type!";
            echo "<script>alert('Cannot upload this file type ! Please try again !');window.location.href='Payment.php';</script>";
        }
    
}
    

//to check rent id status before proceed payment
if(isset($_POST['go'])){ 
        $rent_id = $_POST['rental_id'];
        
            if($rent_id != $rental_id)
            {
                $_SESSION['message2'] = "This rental payment already done! Please check payment history!";
                header("location:Payment.php");
            }
            
                  
?>

<!DOCTYPE html>
<html lang="en">
<head><link rel="icon" href="img/car.ico">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
    <h1>Azure Car Rental</h1>
    <a href="EditDetails.php">
    <img src="img/profile.png" alt="logo" style="float:right;">
</a>
<a href="info.php">
    <img src="img/info.png" alt="logo" style="float:right; width:100px;">
</a>
<a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <nav>
    <div class="wrapper">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="CarRental.php">Cars For Rental</a></li>
            <li><a href="RentalHistory.php">Rental History</a></li>
            <li class="active"><a href="Payment.php">Payment</a></li>
            <li><a href="PaymentHistory.php">Payment History</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <button><a href="Logout.php">Logout</a></button>
        </ul>
    </div>
	</nav>
</header>
</body>
</html>

<!DOCTYPE html>
<html>
<head><link rel="icon" href="img/car.ico">
<title>Payment</title>
<link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
        <div class="input-group">
            <h2>Your total price : RM <?php echo number_format((float)$totalprice, 2, '.', ''); ?></h2><br><br>
            <h3 style="font-family: arial;">Details :</h3>
            <p>Customer Name :  <?php echo $cust_name; ?></p>
            <p>Car Model :  <?php echo $model; ?></p>
            <p>Rate per Hour : RM <?php echo $rate; ?></p>
            <p>Start Time :  <?php echo $start_time; ?></p>
            <p>End Time :  <?php echo $end_time; ?></p>
            <p>Duration :  <?php echo $duration; ?></p>
            <p>Contractual Duration :  <?php echo $contractual_duration; ?> hour(s)</p>
            <p>Overdue charges : RM <?php echo number_format((float)$overdue, 2, '.', ''); ?></p>
            <p>Actual Price : RM <?php echo number_format((float)$total, 2, '.', ''); ?></p><br>
        </div>
        <input type="hidden" name="rental_id" value="<?php echo $rental_id; ?>">
        <input type="hidden" name="overdue" value="<?php echo $overdue; ?>">
        <input type="hidden" name="total_price" value="<?php echo $totalprice; ?>">
        
        <div class="input-group">
			<label>Proof of Payment</label>
			<input type="file" name="file" value="">
			<?php if (isset($_SESSION['message_err4'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err4']; 
				unset($_SESSION['message_err4']);
			?>
			</div>
			<?php endif ?>
        </div>
        <?php if (isset($_SESSION['message3'])): ?>
		<div class="msg3">
			<?php 
				echo $_SESSION['message3']; 
				unset($_SESSION['message3']);
			?>
		</div>
		<?php endif ?>
		<div class="input-group">
			<button type="submit" name="submit" class="btn">Submit</button>
		</div>
	</form>
</body>
</html>
<?php       
  }
?>