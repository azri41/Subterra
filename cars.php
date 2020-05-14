<?php
    require "Config.php";
    

    if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `car` WHERE CONCAT(`car_id`, `plate_no`, `model`, 
    `no_of_seat`, `transmission`, `car_condition`, `rate_hour`) LIKE '%".$valueToSearch."%'";
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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
    <h1>Azure Car Rental</h1>
    <a href="info.php">
    <img src="img/info.png" alt="logo" style="float:right; width:100px;">
</a>
<a href="index.php">
        <img src="img/logo.png" alt="logo">
    </a>
    <nav>
    <div class="wrapper">
        <ul class="index">
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="cars.php">Cars For Rental</a></li>
            <li><a href="AboutUs.php">About Us</a></li>
            <button><a href="Login.php">Login</a></button>
            <button><a href="RegisterCustomer.php">Register</a></button>
        </ul>
    </div>
    </nav>
</header>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<title>List All Car</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>
<form class="display" action="cars.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search">
            <input type="submit" name="search" value="Filter"><br><br>
<table>
	<thead>
		<tr>
            <th>ID</th>
            <th>Image</th>
			<th>Plate No</th>
			<th>Model</th>
            <th>No of Seat</th>
			<th>Transmission</th>
            <th>Condition</th>
			<th>Rate (RM/Hour)</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($search_result)):?>
		<tr>
            <td><?php echo $row['car_id']; ?></td>
            <td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'">' ?></td>
			<td><?php echo $row['plate_no']; ?></td>
            <td><?php echo $row['model']; ?></td>
			<td><?php echo $row['no_of_seat']; ?></td>
            <td><?php echo $row['transmission']; ?></td>
			<td><?php echo $row['car_condition']; ?></td>
            <td><?php echo $row['rate_hour']; ?></td>
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
