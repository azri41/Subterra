<?php 
require "Config.php";
include('server.php'); 
	// fetch the record to be updated
	if(isset($_GET['edit']))
	{
		$id = $_GET['edit'];
		$edit_state = true;
		$rec = mysqli_query($conn, "SELECT * FROM car WHERE car_id=$id");
		
		if (@count($rec) == 1)
		{
			$record = mysqli_fetch_array($rec);
			$id = $record['car_id'];
			$file =$record['image'];
			$plate_no = $record['plate_no'];
     		$model = $record['model'];
        	$seat= $record['no_of_seat'];
        	$trans = $record['transmission'];
        	$condition = $record['car_condition'];
			$rate = $record['rate_hour'];
		}
        
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
<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
<?php endif ?>
<?php if (isset($_SESSION['message2'])): ?>
	<div class="msg2">
		<?php 
			echo $_SESSION['message2']; 
			unset($_SESSION['message2']);
		?>
	</div>
<?php endif ?>

	<form action="server.php" method="POST" enctype="multipart/form-data">
	<h2>Car Details</h2><br><br>
		<div class="input-group">
			<label>Image</label>
			<input type="file" name="file" value="">
			<?php if (isset($_SESSION['message_err5'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err5']; 
				unset($_SESSION['message_err5']);
			?>
			</div>
			<?php endif ?>
		</div>
	<input type="hidden" name="car_id" value="<?php echo $id; ?>">
		<div class="input-group">
			<label>Plate No</label>
			<input type="text" name="plate_no" value="<?php echo $plate_no; ?>" maxlength="14">
			<?php if (isset($_SESSION['message_err'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err']; 
				unset($_SESSION['message_err']);
			?>
			</div>
			<?php endif ?>
		</div>
        <div class="input-group">
			<label>Model</label>
			<input type="text" name="model" value="<?php echo $model; ?>" maxlength="20">
			<?php if (isset($_SESSION['message_err2'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err2']; 
				unset($_SESSION['message_err2']);
			?>
			</div>
			<?php endif ?>
		</div>
		<div class="input-group">
			<label>No of Seat</label>
			<input type="text" name="no_of_seat" value="<?php echo $seat; ?>" maxlength="2">
			<?php if (isset($_SESSION['message_err3'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err3']; 
				unset($_SESSION['message_err3']);
			?>
			</div>
			<?php endif ?>
		</div>
        <div class="input-group">
			<label>Transmission</label>
		</div>
			<label class="container">Manual
			<input type="radio" name="transmission" value="Manual">
			<span class="checkmark"></span>
			</label>
			<label class="container">Auto
			<input type="radio" name="transmission" value="Auto">
			<span class="checkmark"></span>
			</label>
		<div class="input-group">
			<label>Condition</label>
		</div>
			<label class="container">Good
			<input type="radio" name="car_condition" value="Good">
			<span class="checkmark"></span>
			</label>
			<label class="container">Bad
			<input type="radio" name="car_condition" value="Bad">
			<span class="checkmark"></span>
			</label>
        <div class="input-group">
			<label>Rate (Hour)</label>
			<input type="text" name="rate_hour" value="<?php echo $rate; ?>">
			<?php if (isset($_SESSION['message_err4'])): ?>
			<div class="msg_err">
			<?php 
				echo $_SESSION['message_err4']; 
				unset($_SESSION['message_err4']);
			?>
			</div>
			<?php endif ?>
		</div>
		<?php if (isset($_SESSION['message3'])): ?>
		<div class="msg3">
			<?php 
				echo $_SESSION['message3']; 
				unset($_SESSION['message3']);
			?>
		</div>
		<?php endif ?>
		<div class="input-group">
		<?php if ($edit_state == true): ?>
			<button type="submit" name="update" class="btn" style="background: #556B2F;" >Update</button>
			<a class="btn" style="background: #eb001f; text-decoration:none; margin-left:50px;" href="CarAdmin.php">Cancel</a><br><br>
		<?php else: ?>
            <button type="submit" name="save" class="btn">Save</button>
            <a class="btn" style="background: #eb001f; text-decoration:none; margin-left:50px;" href="CarAdmin.php">Cancel</a><br><br>
		<?php endif ?>
		</div>
	</form><br><br><br><br>
    <footer>
    <p>Phone : 06-231 4133 </p>
    <p>Email : carrental@gmail.com </p>
    </footer>
</body>
</html>