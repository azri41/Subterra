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
<head><link rel="icon" href="img/car.ico">
<title>Info</title>
<link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
    <form class="display">
        <h2>Steps To Use This System</h2>
        <p>1) You need to rent car first to proceed the system.</p>
        <p>2) You can choose car from tab "Car for Rentals".</p>
        <p>3) Click "Rent" button, fill in the details.</p>
        <p>4) After that, you can proceed to use the car. But remember, you need to retunr the car based on contractual duration. If the duration exceed the contractual duration, there will be charges (1 hour = RM20).</p>
        <p>5) Click "End Rental" button to end the rent in "Rental History". Then you can proceed to do payment.</p>
        <p>6) Fill in the payment details and you're done! Thank you for using Azure Car Rental system! (You can check the details in "Payment History").</p>
	</form>
</body>
</html>