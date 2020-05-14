<?php
	session_start();
    require "Config.php";

	if (isset($_GET['end']))
	{
        $id = $_GET['end'];

        $query = "SELECT * FROM rental WHERE rental_id='$id'";
        $results = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($results)) { ?>

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
                        <li><a href="Payment.php">Payment</a></li>
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
            <head>
                <title>End Rental</title>
                <link rel="stylesheet" type="text/css" href="crud.css">
            </head>
            <body>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> 
                <h2>End Rental</h2><br><br>
                    <div class="input-group">
                        <label>End Time</label>
                        <input type="datetime-local" name="end_time" value="<?php echo $end; ?>">
                        <?php if (isset($_SESSION['message_err6'])): ?>
			            <div class="msg_err">
			            <?php 
				            echo $_SESSION['message_err6']; 
				            unset($_SESSION['message_err6']);
			            ?>
			            </div>
			            <?php endif ?>
                        <input type="hidden" name="rental_id" value="<?php echo $id ?>">
                        <button type="submit" name="submit_end" class="btn">Submit</button>
                    </div>
                </form>
            </body>
            </html>

 <?php       }
 mysqli_close($conn);
}

        if(isset($_POST['submit_end']))
        {
            $id = $_POST['rental_id'];
            $query = "SELECT * FROM rental WHERE rental_id='$id'";
            $results = mysqli_query($conn, $query);
            $status = "Unpaid";
            while ($row = mysqli_fetch_array($results)){
                $start = $row['start_time'];

                //error handling end time
                if(empty($_POST["end_time"])){
                    $_SESSION['message_err'] = "Please enter the end time!";
                    echo "<script>alert('End time not filled ! Please try again !');window.location.href='RentalHistory.php';</script>";
                }
                else
                {
                    $e = $_POST['end_time'];
                    $endTime = str_replace("T"," ",$e);
        
                    $param_end = $endTime;
                    if($param_end < $start){
                        $_SESSION['message_err6'] = "Please enter end time after current start time!";
                        echo "<script>alert('End time must after start time ! Please try again !');window.location.href='RentalHistory.php';</script>";       
                    }
                    else{
                        $end = $_POST['end_time'];
                        $d1 = new DateTime($start);
                        $d2 = new DateTime($end);
                        $interval = $d2->diff($d1);
                        $int = $interval->format('%d day(s), %H hour(s), %I minute(s)');
                        
                       
                        $sql = "UPDATE rental SET end_time='$end', duration='$int' ,status='$status' WHERE rental_id='$id'"; 
                        if(mysqli_query($conn, $sql))
                        {
                            echo "<script>alert('End rent successful. You can proceed to do payment');window.location.href='Payment.php';</script>"; 
                        }
                        else{
                            echo "<script>alert('Error 404. Please try again later.');window.location.href='RentalHistory.php';</script>";
                        }
                        mysqli_close($conn);

                    }
                        
                }

                
                
            }
            
        } 
?>