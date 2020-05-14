<?php 
require "Config.php";
include('server.php'); 
	// fetch the record to be updated
	

	if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `car` WHERE CONCAT(`car_id`, `plate_no`, `model`, `no_of_seat`, `transmission`, `car_condition`, `rate_hour`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `car`";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    require "Config.php";
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}
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
            <li><a href="AdminMain.php">Home</a></li>
            <li class="active"><a href="CarAdmin.php">Cars For Rental</a></li>
			<li><a href="RentalHistory.php">Rental History</a></li>
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
<meta charset="UTF-8">
	<title>CRUD Car</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<form class="display" action="CarAdmin.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search">
			<input type="submit" name="search" value="Filter">
			<a class="btn" style="background: #FF6347; text-decoration:none; margin-left:100px;" href="AddCar.php">Go to Add Car</a><br><br>
<table>
	<thead>
		<tr>
            <th class="car">ID</th>
			<th class="car">Image</th>
			<th class="car">Plate No</th>
			<th class="car">Model</th>
            <th class="car">No of Seat</th>
			<th class="car">Transmission</th>
            <th class="car">Condition</th>
			<th class="car">Rate (RM/Hour)</th>
			<th colspan="2" class="car">Action</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($search_result)):?>
		<tr>
			
			<td><?php echo $row['car_id']; ?></td>
			<td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'">' ;?></td> 
			<td><?php echo $row['plate_no']; ?></td>
            <td><?php echo $row['model']; ?></td>
			<td><?php echo $row['no_of_seat']; ?></td>
            <td><?php echo $row['transmission']; ?></td>
			<td><?php echo $row['car_condition']; ?></td>
            <td><?php echo $row['rate_hour']; ?></td>

			<td>
				<a href="AddCar.php?edit=<?php echo $row['car_id']; ?>" class="edit_btn" >Edit</a>
			</td>
			<td>
				<a href="server.php?del=<?php echo $row['car_id']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
		<?php endwhile;?>
</table>
	</form><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>