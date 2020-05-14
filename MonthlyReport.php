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

$query="SELECT * FROM car c, rental r, customer cu WHERE c.car_id=r.car_id AND r.cust_id=cu.cust_id AND  status='Paid'";
$query_result = mysqli_query($conn, $query);
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
	<title>Monthly Report</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			Start Date &nbsp;&nbsp;&nbsp;&nbsp; <input type="date" name="startdate"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			End Date &nbsp;&nbsp;&nbsp;&nbsp; <input type="date" name="enddate">
<input style="background: #4B99AD; padding: 8px 15px 8px 15px; border: none; color: #fff; margin:0px 0px 0px 100px" type="submit" name="salereport" value="Show Report">
</form>

<div>
		<?php if(isset($_POST['salereport'])) {
			$start=$_POST['startdate'];
			$end=$_POST['enddate'];
			$current_date = date("Y-m-d");
            echo "<h2>Rental made between $start and $end</h2>";
            
			//check if the date is relevant
			if ($start>=$current_date || $end>$current_date || $end<$start) {
				?><br><?php echo "<script>alert('Please select the date before today!');window.location.href='MonthlyReport.php';</script>";
            }
            else
            {
				$result=mysqli_query($conn,"SELECT * FROM car c, rental r, customer cu, payment p WHERE r.date between '$start' and '$end' AND r.status='Paid' 
                AND c.car_id=r.car_id AND r.cust_id=cu.cust_id AND p.rental_id=r.rental_id ORDER BY r.date");
			    $viewtotal=mysqli_num_rows($result);
			    if ($viewtotal==0) {
			    ?><br><?php echo "<h3>There is no booking history.</h3>";
			    }
			    else{
                ?><br><?php echo "<h3>There was $viewtotal booking</h3>";
                
                $totalpricenew=0;?>
                
			    <table style="width: 40%;">
			    <thead>
			    <tr text-align="center" style="background-color: #2a2a8b;color: white;">
				    <th>DATE</th>
				    <th>CUSTOMER IC</th>
				    <th>CAR</th>
				    <th>PRICE</th>
			    </tr>
                </thead><tbody>
                <?php

			    //display report details
			    while ($row = mysqli_fetch_array($result)){
				    $totalprice=$row['total_price']?>
					    <tr text-align="center" style="background-color: white;">
						    <td><?php echo $row['date']; ?></td>
						    <td><?php echo $row['ic_no']; ?></td>
						    <td><?php echo $row['model']; ?></td>
						    <td><?php echo "RM ".$totalprice; ?></td>
					    </tr>
			    <?php $totalpricenew=$totalpricenew+$totalprice;}?>
			    <tr text-align="center">
				    <td colspan="3" style="background-color: #2a2a8b;color: white;">TOTAL PRICE</td>
				    <td style="background-color: white;"><?php echo "RM ".$totalpricenew; ?></td>
			    </tr>
			    </tbody> </table><?php
			    }
			}	
		}?> 
	</div>

</body>
</html>
