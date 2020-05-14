<?php
require "Config.php";
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: Login.php");
    exit;
}

$username=$_SESSION['username'];

$sql="SELECT * FROM customer WHERE users_id=(SELECT users_id FROM users WHERE username='$username')";

if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $cust_id=$row['cust_id'];
            $cust_name=$row['cust_name'];    
        }
    // Free result set
    mysqli_free_result($result);
    }
}


$query = "SELECT `car_id` FROM   rental GROUP BY `car_id` ORDER BY COUNT(*) DESC LIMIT 2";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head><link rel="icon" href="img/car.ico">
    <meta charset="UTF-8">
    <title>Car Rental Management System</title>
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
            <li class="active"><a href="UserMain.php">Home</a></li>
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
    <div class="wrapper-form">
    <h2>Welcome , <?php echo $cust_name ?> !</h2><br>
    </div>
    <img src="img/hot.png" style=" width:15%; height:15%;"><br>
    <div class="hot-picks">
    <?php 
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $car_id=$row['car_id'];
                
                $sql="SELECT * FROM car WHERE car_id='$car_id'";
                $result2 = mysqli_query($conn, $sql);
                $row2 = mysqli_fetch_assoc($result2);
                echo '<table><tr>';
                echo '<br><img style="width : 30%; height:30%;" src="data:image/jpeg;base64,'.base64_encode($row2['image']).'">' ;
                echo "<td>".$row2['model']."</td>";
                echo "<td>".$row2['transmission']."</td>";
                echo "<td>"."Rate/Hour : RM ".$row2['rate_hour']."</td>";
                echo '</table></tr>' ;
            }	
        } ?>
    </div><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>

