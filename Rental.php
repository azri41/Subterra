<?php
session_start();
require "Config.php";
$username=$_SESSION['username'];

$timezone = +8;
$start = $contract = $status="";
$startUnpaid = $endUnpaid = $startRenting = "";

//Get cust_id by using username
$sql="SELECT cust_id FROM customer WHERE users_id=(SELECT users_id FROM users WHERE username='$username')";

if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $cust_id=$row['cust_id'];    
        }
    // Free result set
    mysqli_free_result($result);
    }
}

$sql = "SELECT * FROM rental WHERE cust_id='$cust_id'";
    $results = mysqli_query($conn, $sql); 

    while ($row = mysqli_fetch_array($results)) {
        $status = $row['status'];       
    }
    if (isset($_GET['rent']))
    {
        $car_id = $_GET['rent'];
        if($status == "Unpaid" || $status == "Renting"){
            echo "<script>alert('You cannot rent other car right now !');window.location.href='RentalHistory.php';</script>"; 
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
            <li><a href="UserMain.php">Home</a></li>
            <li><a href="CarRental.php">Cars For Rental</a></li>
            <li><a href="RentalHistory.php">Rental History</a></li>
            <li><a href="PaymentHistory.php">Payment History</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <button><a href="Logout.php">Logout</a></button>
        </ul>
    </div>
    </nav>
</body>
</header>
</html>

<!DOCTYPE html>
<html>
<head><link rel="icon" href="img/car.ico">
	<title>Rent Car</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
    <input type="hidden" name="rental_id" value="<?php echo $rental_id; ?>">
		<div class="input-group"> 
			<input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
		</div>
        <div class="input-group">
			<input type="hidden" name="cust_id" value="<?php echo $cust_id; ?>">
		</div>
        <h2>Rent Car</h2><br><br>
        <div class="input-group">
			<label>Start Time</label>
			<input type="datetime-local" name="start_time" value="<?php echo $start; ?>">
            <?php if (isset($_SESSION['message_err2'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err2']; 
				unset($_SESSION['message_err2']);
			?>
			</div>
			<?php endif ?>
		</div>
        <div class="input-group">
			<label>Contractual Duration (Hour(s))</label>
			<input type="number" name="contractual_duration" min="1" max="120" step="1" value="<?php echo $contract; ?>" placeholder="Maximum is 5 days = 120 hours">
            <?php if (isset($_SESSION['message_err3'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err3']; 
				unset($_SESSION['message_err3']);
			?>
			</div>
			<?php endif ?>
		</div>
		<div class="input-group">
			<button type="submit" name="submit" class="btn">Submit</button>
		</div>
	</form>
</body>
</html>
        
<?php     
}   
    if(isset($_POST['submit']))
    {
        //start time
        if(empty($_POST["start_time"])){
            $_SESSION['message_err2'] = "Please enter the start time!";
            echo "<script>alert('Start time not filled ! Please try again !');window.location.href='CarRental.php';</script>";
        }
        else
        {
            $s = $_POST['start_time'];
            $startTime = str_replace("T"," ",$s);
            $dateTimeToday = gmdate("Y-m-d H:i", time() + 3600*$timezone);

            $param_start = $startTime;
            if($param_start < $dateTimeToday){
                $_SESSION['message_err2'] = "Please enter start time after current time!";
                echo "<script>alert('Start time must after current time ! Please try again !');window.location.href='CarRental.php';</script>";
                exit();       
            }
            else
                $start = $_POST['start_time'];
        }
        
        //contractual_duration
        if(empty($_POST["contractual_duration"])){
            $_SESSION['message_err3'] = "Please enter the duration!";
            echo "<script>alert('Duration not filled ! Please try again !');window.location.href='CarRental.php';</script>";
        }
        else
        {
            $param_dur = $_POST['contractual_duration'];
            if(!filter_var($param_dur, FILTER_VALIDATE_INT)){
                $_SESSION['message_err3'] = "You have entered invalid number!";
                echo "<script>alert('Invalid duration ! Please try again !');window.location.href='CarRental.php';</script>";
            }
            else if(trim($_POST["contractual_duration"]) < 1){
                $_SESSION['message_err3'] = "Please enter duration more than 0!";
                echo "<script>alert('Duration must in positive number ! Please try again !');window.location.href='CarRental.php';</script>";
            }
            else
                $contract = $_POST['contractual_duration'];
        }
        

        //checking before enter database
        if(empty($_POST["start_time"]) || empty($_POST["contractual_duration"]))
        {
            $_SESSION['message3'] =  "Please fill up the form!.";
            echo "<script>alert('Form not filled ! Please try again !');window.location.href='CarRental.php';</script>";
        }
        else if($_POST["contractual_duration"] == 0)
        {
            echo "<script>alert('Duration must bigger than 0 ! Please try again !');window.location.href='CarRental.php';</script>";
        }
        else{
            $car_id = $_POST['car_id'];
            $cust_id = $_POST['cust_id'];

            $s = $_POST['start_time'];
            $start = str_replace("T"," ",$s);

            $query="SELECT * FROM rental WHERE car_id='$car_id' AND status='Unpaid'";
            $Result = mysqli_query($conn,$query);
            while($row = mysqli_fetch_array($Result)){
                $startUnpaid=$row['start_time'];
                $endUnpaid=$row['end_time'];
            }
            echo "Start Unpaid = ".$startUnpaid."<br>";
            echo "End Unpaid = ".$endUnpaid."<br>";

            $query2="SELECT * FROM rental WHERE car_id='$car_id' AND status='Renting'";
            $Result2 = mysqli_query($conn,$query2);
            while($row = mysqli_fetch_array($Result2)){
                $startRenting=$row['start_time'];
            }
            
            //to check whether date time clashes or not
            if($startRenting == "")
            {
                //set timezone
                date_default_timezone_set('GMT');

                //display the converted time
                $startWithDuration= date('Y-m-d H:i',strtotime('+'.$contract.' hour',strtotime($start)));

                if($start > $startUnpaid && $start < $endUnpaid)
                {
                    echo "<script>alert('This car is being used by other customer ! Please try again !');window.location.href='CarRental.php';</script>";
                }
                else if($startWithDuration < $startRenting){
                    echo "<script>alert('This car is being used during that time ! Please try again !');window.location.href='CarRental.php';</script>";
                }
                else{
                    $date = date("Y-m-d");
                    
                    $status = "Renting";

                    $sql= "INSERT INTO rental(date, start_time, contractual_duration, car_id, cust_id, status) VALUES ('$date', '$start', '$contract', '$car_id', '$cust_id', '$status')";
                    if(mysqli_query($conn, $sql))
                    {
                        echo "<script>alert('Rent successful. You can check the details in the rental history');window.location.href='RentalHistory.php';</script>"; 
                    }
                    else{
                        echo "<script>alert('Error 404. Please try again later.');window.location.href='CarRental.php';</script>";
                    }
                } 	
            }
            else
            {
                //set timezone
                date_default_timezone_set('GMT');

                //display the converted time
                $startWithDuration= date('Y-m-d H:i',strtotime('+'.$contract.' hour',strtotime($start)));

                if($start > $startUnpaid && $start < $endUnpaid)
                {
                    echo "<script>alert('This car is being used by other customer ! Please try again !');window.location.href='CarRental.php';</script>";
                }
                else if($startWithDuration > $startRenting){
                    echo "<script>alert('This car is being used during that time ! Please try again !');window.location.href='CarRental.php';</script>";
                }
                else{
                    $date = date("Y-m-d");
                    
                    $status = "Renting";
                    
                    $sql= "INSERT INTO rental(date, start_time, contractual_duration, car_id, cust_id, status) VALUES ('$date', '$start', '$contract', '$car_id', '$cust_id', '$status')";
                    if(mysqli_query($conn, $sql))
                    {
                        echo "<script>alert('Rent successful. You can check the details in the rental history');window.location.href='RentalHistory.php';</script>"; 
                    }
                    else{
                        echo "<script>alert('Error 404. Please try again later.');window.location.href='CarRental.php';</script>";
                    }
                } 	
            }
            
        }
        mysqli_close($conn);
    }

    if(isset($_POST['update']))
    {
        $id = $_POST['update'];
        $status = $_POST['status'];

        $sql = "UPDATE rental SET status='$status' WHERE rental_id=$id";
        mysqli_query($conn, $sql);

        if(mysqli_query($conn, $sql))
        {
            echo "<script>alert('Update successful !');window.location.href='RentalHistory.php';</script>"; 
        }
        else{
            echo "<script>alert('Error 404. Please try again later.');window.location.href='RentalHistory.php';</script>";
        }    
    }
?>