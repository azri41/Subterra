<?php 
    if(isset($_POST['go']))
    {
        header('location: CarRental.php');
    }
    else if(isset($_POST['cancel'])){
        header('location: index.php');
    }
?>

<!DOCTYPE html>
	<html>
	<head><link rel="icon" href="img/car.ico">
	<title>Confirm</title>
    <link rel="stylesheet" type="text/css" href="crud.css">
	</head>
	<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
    <div class = "input-group">
    <h2>You need to rent car first !</h2>
		<button type="submit" name="go" class="btn" >Go to Rental Cars</button>
		<button type="submit" name="cancel" class="btn">Cancel</button>
		</div>
	</form>
	</body>
</html> 