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

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `rental` WHERE CONCAT(`rental_id`, `date`, `car_id`,`cust_id`,`status`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `rental`";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    require "Config.php";
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}

//Admin
if($_SESSION["usertype"]=="Admin")
{
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
<a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <nav>
    <div class="wrapper">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="CarAdmin.php">Cars For Rental</a></li>
			<li class="active"><a href="RentalHistory.php">Rental History</a></li>
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
	<title>Rental History</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<form class="display" action="RentalHistory.php" method="post">
<input type="text" name="valueToSearch" placeholder="Rental ID/Car ID/Customer ID/Booking Date/Status">
            <input type="submit" name="search" value="Filter"><br><br>
<table>
	<thead>
		<tr>
            <th>Rental ID</th>
			<th>Car ID</th>
			<th>Customer ID</th>
            <th>Date</th>
			<th>Start Time</th>
			<th>End Time</th>
            <th>Duration</th>
			<th>Contractual Duration (Hour(s))</th>
			<th>Status</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($search_result)):  ?>
		<tr><form action="Rental.php" method="post">
			<td><?php echo $row['rental_id']; ?></td>
			<td><?php echo $row['car_id']; ?></td>
			<td><?php echo $row['cust_id']; ?></td>
			<td><?php echo $row['date']; ?></td>
            <td><?php echo $row['start_time']; ?></td>
			<td><?php echo $row['end_time']; ?></td>
            <td><?php echo $row['duration']; ?></td>
			<td><?php echo $row['contractual_duration']; ?></td>			
			<td><?php echo $row['status']; ?></td>
	</form></tr>
	<?php endwhile; ?>
</table>
</form><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>

<?php }

//Customer
else if($_SESSION["usertype"]=="Customer")
{
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
	$results = mysqli_query($conn, $sql); ?>

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
			<li class="active"><a href="RentalHistory.php">Rental History</a></li>
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
	<title>Rental History</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>

<table>
	<thead>
		<tr>
            <th>Rental ID</th>
			<th>Car ID</th>
			<th>Customer ID</th>
            <th>Booking Date</th>
			<th>Start Time</th>
			<th>End Time</th>
            <th>Duration</th>
			<th>Contractual Duration (Hour(s))</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<?php if(mysqli_num_rows($results) == 0){
		echo '<tr><td><h2>No results</h2></td></tr>';
	} 
	else{
		?>
	<?php while ($row = mysqli_fetch_array($results)){ ?>
		<tr>
			<td><?php echo $row['rental_id']; ?></td>
			<td><?php echo $row['car_id']; ?></td>
			<td><?php echo $row['cust_id']; ?></td>
			<td><?php echo $row['date']; ?></td>
            <td><?php echo $row['start_time']; ?></td>
			<td><?php echo $row['end_time']; ?></td>
            <td><?php echo $row['duration']; ?></td>
			<td><?php echo $row['contractual_duration']; ?></td>
			<td><?php echo $row['status']; ?></td>
			<?php if($row['status'] == 'Paid' || $row['status'] == 'Unpaid'){ } 
			else { ?>
			<td>
				<a href="EndRental.php?end=<?php echo $row['rental_id']; ?>" class="del_btn">End Rent</a>
			</td> <?php } ?>
		</tr>
	<?php } ?>
</table>

    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>

<?php } } ?>