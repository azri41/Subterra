<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head><link rel="icon" href="img/car.ico"> 
    <meta charset="UTF-8">
    <meta name="decription" content="This is an example of a meta description. This will often show up in search results.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>
      
        Car Rental Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Azure Car Rental</h1>
        <a href="index.php">
                <img src="img/logo.png" alt="logo">
            </a>
           
        <nav>
            <ul class="index">
             <li><a href="index.php">Home</a></li>
             <li><a href="cars.php">Cars For Rental</a></li>
             <li><a href="AboutUs.php">About Us</a></li>
            </ul>
            <div class="header-input">
                <?php
                    if(isset($_SESSION['usertype'])){
                        echo '<button><a href="Logout.php">Logout</a></button>';
                    }
                    else{
                        echo '<button><a href="Login.php">Login</a></button>
                        <button><a href="RegisterCustomer.php">Register</a></button>';
                    }

                ?>   
            </div>
        </nav>

    </header>
 
</body>
</html>