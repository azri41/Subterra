<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: Login.php");
    exit;
}

$username=$_SESSION['username'];
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
<a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <nav>
    <div class="wrapper">
        <ul>
            <li class="active"><a href="AdminMain.php">Home</a></li>
            <li><a href="CarAdmin.php">Cars For Rental</a></li>
            <li><a href="RentalHistory.php">Rental History</a></li>
            <li><a href="PaymentHistory.php">Payment History</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <button><a href="Logout.php">Logout</a></button>
        </ul>
    </div>
    </nav>
</header>
    <div class="wrapper-form">
    <h2>Welcome , <?php echo $username ?> !</h2>
    </div><br><br><br><br><br><br>
    <div class="display">
    <table style="width:100%;">
        <tr style="border-bottom: none;">
        <!-- <td style="text-align: left;"><button>Display all customers</button></td> -->
        <td style="text-align: centre;"><a href="RegisterAdmin.php">
            <button style="padding:20px; background-color:blue; font-family:arial; font-size:20px; font-weight:bold; color:white; border-radius: 50%;">Add Admin</button></a></td>
        <td style="text-align: centre;"><a href="MonthlyReport.php">
            <button style="padding:20px; background-color:blue; font-family:arial; font-size:20px; font-weight:bold; color:white; border-radius: 50%;">Generate Report</button></a></td>
    </tr></table>
    </div><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>


