<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: Login.php");
    exit;
}

//admin
if($_SESSION["usertype"]=="Admin")
{
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
            <li><a href="index.php">Home</a></li>
            <li><a href="CarAdmin.php">Cars For Rental</a></li>
            <li><a href="RentalHistory.php">Rental History</a></li>
            <li><a href="PaymentHistory.php">Payment History</a></li>
            <li class="active"><a href="Contact.php">Contact</a></li>
            <button><a href="Logout.php">Logout</a></button>
        </ul>
    </div>
    </nav>
</header>
<div class="contact" style="text-align:center;">
    <h1>Azure Car Rental</h1><br><br><br>
    <h2>Address :  Lot 10123, Jalan TU 43, Kawasan Perindustrian Ayer Keroh, 75450 Ayer Keroh, Melaka</h2><br>
    <h2>Phone : 06-231 4133</h2>
</div>
</body>
</html>

<?php }//customer 
else if($_SESSION["usertype"]=="Customer")
{ ?>
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
            <li><a href="index.php">Home</a></li>
            <li><a href="CarRental.php">Cars For Rental</a></li>
            <li><a href="RentalHistory.php">Rental History</a></li>
            <li><a href="Payment.php">Payment</a></li>
            <li><a href="PaymentHistory.php">Payment History</a></li>
            <li class="active"><a href="Contact.php">Contact</a></li>
            <button><a href="Logout.php">Logout</a></button>
        </ul>
    </div>
    </nav>
</header>
<div class="contact" style="text-align:center;">
    <h1>Azure Car Rental</h1><br><br><br>
    <h2>Address :  Lot 10123, Jalan TU 43, Kawasan Perindustrian Ayer Keroh, 75450 Ayer Keroh, Melaka</h2><br>
    <h2>Phone : 06-231 4133</h2>
</div>
</body>
</html>
<?php } ?>
