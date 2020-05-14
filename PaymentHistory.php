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
    $query = "SELECT * FROM `payment` WHERE CONCAT(`pay_id`, `pay_date`, `rental_id`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `payment`";
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
			<li><a href="RentalHistory.php">Rental History</a></li>
            <li class="active"><a href="PaymentHistory.php">Payment History</a></li>
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
	<title>Payment History</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<form class="display" action="PaymentHistory.php" method="post">
<input type="text" name="valueToSearch" placeholder="Rental ID/Pay ID/Pay Date">
            <input type="submit" name="search" value="Filter"><br><br>
<table>
	<thead>
		<tr>
            <th>Rental ID</th>
            <th>Pay ID</th>
			<th>Pay Date</th>
			<th>Actual Price</th>
            <th>Overdue Charges (RM)</th>
            <th>Total Price (RM)</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($search_result)): ?>
		<tr>
			<td><?php echo $row['rental_id']; ?></td>
			<td><?php echo $row['pay_id']; ?></td>
			<td><?php echo $row['pay_date']; ?></td>
			<td><?php echo $row['actual_price']; ?></td>
            <td><?php echo $row['overdue_charge']; ?></td>
			<td><?php echo $row['total_price']; ?></td>			
		<td><div class="input-group">
		<a href="receipt/invoice-db.php?pay=<?php echo $row['pay_id']; ?>" class="rent_btn" >Print</a>
		</div></td>
	</form></tr>
	<?php endwhile; ?>
</table>
</form>
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

	$sql2 = "SELECT * FROM payment WHERE rental_id IN (SELECT rental_id FROM rental WHERE cust_id='$cust_id' AND status='Paid')";
    $result2 = mysqli_query($conn, $sql2); ?>
    
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
            <li class="active"><a href="PaymentHistory.php">Payment History</a></li>
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
	<title>Payment History</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>

<table>
	<thead>
		<tr>
            <th>Rental ID</th>
            <th>Pay ID</th>
			<th>Pay Date</th>
			<th>Actual Price</th>
            <th>Overdue Charges</th>
            <th>Total Price</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($result2)) { ?>
		<tr>
			<td><?php echo $row['rental_id']; ?></td>
			<td><?php echo $row['pay_id']; ?></td>
			<td><?php echo $row['pay_date']; ?></td>
			<td><?php echo 'RM '.$row['actual_price']; ?></td>
            <td><?php echo 'RM '.$row['overdue_charge']; ?></td>
			<td><?php echo 'RM '.$row['total_price']; ?></td>			
		<td><div class="input-group">
		<a href="receipt/invoice-db.php?pay=<?php echo $row['pay_id']; ?>" class="rent_btn" >Print</a>
		</div></td>
	</form></tr>
	<?php } ?>
</table><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>

<?php }  ?>