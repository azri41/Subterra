<?php
    session_start();
    require "Config.php";
    $rental_id="";
    $username = $_SESSION["username"];
	$sql="SELECT cust_id FROM customer WHERE users_id=(SELECT users_id FROM users WHERE username='$username')";

	if($result = mysqli_query($conn, $sql)){
    	if(mysqli_num_rows($result) > 0){
        	while($row = mysqli_fetch_array($result)){
            	$cust_id=$row['cust_id'];    
        	}
    	mysqli_free_result($result);
    	}
	}

	$sql = "SELECT * FROM rental WHERE cust_id='$cust_id'";
    $results = mysqli_query($conn, $sql); 
    if(mysqli_num_rows($results) == 0)
    {
        echo "<script>alert('You need to rent car first !');window.location.href='CarRental.php';</script>"; 
    }
    else
    {
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
            
            
            $sql="SELECT * FROM car WHERE car_id = '$car_id'";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $rate=$row['rate_hour'];    
                    }
                mysqli_free_result($result);
                }
            }
        }
        
        if($status == "Renting")
        {
            echo "<script>alert('You need to end renting first before proceed to payment !');window.location.href='RentalHistory.php';</script>"; 
        }
        
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
<html lang="en">
<head><link rel="icon" href="img/car.ico">
<meta charset="UTF-8">
	<title>Payment</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<?php if (isset($_SESSION['message2'])): ?>
	<div class="msg2">
		<?php 
			echo $_SESSION['message2']; 
			unset($_SESSION['message2']);
		?>
	</div>
<?php endif ?>
<form method="POST" action="PaymentConfirmation.php" >
<h2>Payment</h2><br><br>
<div class="input-group">
<label>Rental ID</label>
<input type="text" name="rental_id" value="<?php echo $rental_id; ?>">
</div>
<div class="input-group">
			<button type="submit" name="go" class="btn">Submit</button>
		</div>
</form>
</body>
</html>

<?php 
    } 
?>