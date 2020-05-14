<?php
	session_start();
    require "Config.php";

	// initialize variables
$plate_no = $model = $seat = $trans = $condition = $rate = "";

$id = 0;
$edit_state = false;

//if save btn clicked
if(isset($_POST['save']))
{
 // plate_no
        if(empty($_POST["plate_no"])){
            $_SESSION['message_err'] ="Please enter the plate number!";
            header('location: AddCar.php');
        }
        
        else{
            //sql statement prep to check for existing plate number.
            $sql = "SELECT car_id FROM car WHERE plate_no = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "s", $param_plate_no);
    
                //assigning value to to parameters
                $param_plate_no = $_POST["plate_no"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);
                    
                    $pattern = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $_SESSION['message_err'] = "A car with this plate number already exists!";
                        header('location: AddCar.php');
                    }
                    else if(strlen(trim($_POST["plate_no"])) < 5){
                        $_SESSION['message_err'] ="Plate number must be at least 5 characters!";
                        header('location: AddCar.php');
                    }
                    else if(preg_match($pattern, $param_plate_no)){
                        $_SESSION['message_err'] ="Plate number must not contain special characters!";
                        header('location: AddCar.php');
                    }
                    else
                        $plate_no = $_POST["plate_no"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later!";
                    header('location: AddCar.php');
                }
            }
            mysqli_stmt_close($stmt);
        }

    //model
        $pattern = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
        $param_model = $_POST["model"];
        if(empty($_POST["model"])){
            $_SESSION['message_err2'] = "Please enter car model!";
            header('location: AddCar.php');
        }
        else if(preg_match($pattern, $param_model))
        {
            $_SESSION['message_err2'] = "Car model must not contain special characters!";
            header('location: AddCar.php');
        }
        else
            $model = $_POST["model"];


    //no of seat

        if(empty($_POST["no_of_seat"])){
            $_SESSION['message_err3'] ="Please enter number of car seat!";
            header('location: AddCar.php');
        }
        else{
            $sql = "SELECT car_id FROM car WHERE no_of_seat = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "i", $param_seat);
    
                //assigning value to to parameters
                $param_seat = $_POST["no_of_seat"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);

                    if(!filter_var($param_seat, FILTER_VALIDATE_INT)){
                        $_SESSION['message_err3'] = "You have entered invalid number!";
                        header('location: AddCar.php');
                    }
                    else if(trim($_POST["no_of_seat"]) < 0){
                        $_SESSION['message_err3'] = "Please enter no of seat more than 0!";
                        header('location: AddCar.php');
                    }
                    else
                        $seat = $_POST["no_of_seat"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later!";
                    header('location: AddCar.php');
                }
            }
    
            mysqli_stmt_close($stmt);
        }


    //rate

        if(empty($_POST["rate_hour"])){
            $_SESSION['message_err4'] = "Please enter price rate per hour!";
            header('location: AddCar.php');
        }
        else{
            $sql = "SELECT car_id FROM car WHERE rate_hour = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "i", $param_rate);
    
                //assigning value to to parameters
                $param_rate = $_POST["rate_hour"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);

                    if(!filter_var($param_rate, FILTER_VALIDATE_INT)){
                        $_SESSION['message_err4'] = "You have entered invalid number!";
                        header('location: AddCar.php');
                    }
                    else if(trim($_POST["rate_hour"]) < 0){
                        $_SESSION['message_err4'] = "Please enter price rate more than 0!";
                        header('location: AddCar.php');
                    }
                    else
                        $rate = $_POST["rate_hour"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later.";
                    header('location: AddCar.php');
                }
            }
    
            mysqli_stmt_close($stmt);
        }

    //image
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    
    if(in_array($fileActualExt, $allowed))
    {
        if($fileError === 0)
        {
            if($fileSize < 1000000){

                if(empty($_POST["plate_no"]) && empty($_POST["model"]) && empty($_POST["no_of_seat"]) && empty($_POST["transmission"]) && empty($_POST["car_condition"]) && empty($_POST["rate_hour"]))
                {
                    $_SESSION['message3'] =  "Please fill up the form!.";
                    header('location: AddCar.php');
                }
                else
                {
                    $file = addslashes(file_get_contents($fileTmpName));
                    $trans = $_POST['transmission'];
                    $condition = $_POST['car_condition'];

                    $sql = "INSERT INTO car (`car_id` , `plate_no`, `model`, `no_of_seat`, `transmission`, `car_condition`, `rate_hour` , `image`) 
                    VALUES (default,'$plate_no', '$model', '$seat', '$trans', '$condition', '$rate' , '$file')";
            
                    if(mysqli_query($conn, $sql)){    
                        $_SESSION['message'] = "New entry has been saved !";

                        echo "<script>alert('New entry has been added!');window.location.href='CarAdmin.php';</script>"; 
                    }
                    else{
                        $_SESSION['message2'] =  "Something went wrong. Please try again later.";
                        echo "<script>alert('Something went wrong. Please try again later.');window.location.href='CarAdmin.php';</script>"; 
                    } 
                }
                
            }
            else
            {
                $_SESSION['message_err5'] = "Your file size is too big!";
                header('location: AddCar.php');
            }
        }
        else
        {
            $_SESSION['message_err5'] = "There was an error uploading your file!";
            header('location: AddCar.php');
        }
    }
    else{
        $_SESSION['message_err5'] = "You cannot upload file of this type!";
        header('location: AddCar.php');
    }
    
}


// update records
	if(isset($_POST['update']))
	{
        $id = $_POST['car_id'];

        if(empty($_POST["plate_no"])){
            $_SESSION['message_err'] ="Please enter the plate number!";
            header('location: AddCar.php');
        }
        
        else{
            //sql statement prep to check for existing plate number.
            $sql = "SELECT car_id FROM car WHERE plate_no = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "s", $param_plate_no);
    
                //assigning value to to parameters
                $param_plate_no = $_POST["plate_no"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) > 1){
                        $_SESSION['message_err'] = "A car with this plate number already exists!";
                        header('location: AddCar.php');
                    }
                    else if(strlen(trim($_POST["plate_no"])) < 5){
                        $_SESSION['message_err'] ="Plate number must be at least 5 characters!";
                        header('location: AddCar.php');
                    }
                    else
                        $plate_no = $_POST["plate_no"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later!";
                    header('location: AddCar.php');
                }
            }
            mysqli_stmt_close($stmt);
        }
        
         //model

        if(empty($_POST["model"])){
            $_SESSION['message_err2'] = "Please enter car model!";
            header('location: AddCar.php');
        }

        else
            $model = $_POST["model"];


    //no of seat

        if(empty($_POST["no_of_seat"])){
            $_SESSION['message_err3'] ="Please enter number of car seat!";
            header('location: AddCar.php');
        }
        else{
            $sql = "SELECT car_id FROM car WHERE no_of_seat = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "i", $param_seat);
    
                //assigning value to to parameters
                $param_seat = $_POST["no_of_seat"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);

                    if(!filter_var($param_seat, FILTER_VALIDATE_INT)){
                        $_SESSION['message_err3'] = "You have entered invalid number!";
                        header('location: AddCar.php');
                    }
                    else if(strlen(trim($_POST["no_of_seat"]) < 0)){
                        $_SESSION['message_err3'] = "Please enter no of seat more than 0!";
                        header('location: AddCar.php');
                    }
                    else
                        $seat = $_POST["no_of_seat"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later!";
                    header('location: AddCar.php');
                }
            }
    
            mysqli_stmt_close($stmt);
        }


    //rate

        if(empty($_POST["rate_hour"])){
            $_SESSION['message_err4'] = "Please enter price rate per hour!";
            header('location: AddCar.php');
        }
        else{
            $sql = "SELECT car_id FROM car WHERE rate_hour = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "i", $param_rate);
    
                //assigning value to to parameters
                $param_rate = $_POST["rate_hour"];
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);

                    if(!filter_var($param_rate, FILTER_VALIDATE_INT)){
                        $_SESSION['message_err4'] = "You have entered invalid number!";
                        header('location: AddCar.php');
                    }
                    else if(strlen(trim($_POST["rate_hour"]) < 0)){
                        $_SESSION['message_err4'] = "Please enter price rate more than 0!";
                        header('location: AddCar.php');
                    }
                    else
                        $rate = $_POST["rate_hour"];
                }
                else{
                    $_SESSION['message2'] = "Oops! Something went wrong. Please try again later.";
                    header('location: AddCar.php');
                }
            }
    
            mysqli_stmt_close($stmt);
        }

    //image
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    
    if(in_array($fileActualExt, $allowed))
    {
        if($fileError === 0)
        {
            if($fileSize < 1000000){

                    if(empty($_POST["plate_no"]) && empty($_POST["model"]) && empty($_POST["no_of_seat"]) && empty($_POST["transmission"]) && empty($_POST["car_condition"]) && empty($_POST["rate_hour"]))
                    {
                        $_SESSION['message3'] =  "Please fill up the form!.";
                        header('location: AddCar.php');
                    }
                    else
                    {
                        $file = addslashes(file_get_contents($fileTmpName));
                        $trans = $_POST['transmission'];
                        $condition = $_POST['car_condition'];

                        $sql = "UPDATE car SET plate_no='$plate_no', model='$model', no_of_seat='$seat', transmission='$trans', 
                        car_condition='$condition', rate_hour='$rate' , image='$file' WHERE car_id=$id";
            
                        if(mysqli_query($conn, $sql)){    
                            $_SESSION['message'] = "Entry has been updated !"; 

                            echo "<script>alert('Entry has been updated!');window.location.href='CarAdmin.php';</script>"; 
                        }
                        else{
                            $_SESSION['message2'] =  "Something went wrong. Please try again later.";
                            echo "<script>alert('Something went wrong. Please try again later.');window.location.href='CarAdmin.php';</script>"; 
                        } 
                    }
                    mysqli_close($conn);
                
                }
            else
                {
                    $_SESSION['message_err5'] = "Your file size is too big!";
                    header('location: AddCar.php');
                }   
            }
        else
            {
                $_SESSION['message_err5'] = "There was an error uploading your file!";
                header('location: AddCar.php');
            }
        }
    else{
            $_SESSION['message_err5'] = "You cannot upload file of this type!";
            header('location: AddCar.php');
        }
    
    }


	// delete records
	if (isset($_GET['del']))
	{
        $id = $_GET['del'];

			if(mysqli_query($conn, "DELETE FROM car WHERE car_id=$id")){
				$_SESSION['message2'] = "Entry has been deleted !";
				echo "<script>alert('Entry has been deleted !');window.location.href='CarAdmin.php';</script>"; 
			}
			else{
				$_SESSION['message2'] = "Error occured during delete the entry ! ";
				echo "<script>alert('Error occured during delete the entry !');window.location.href='CarAdmin.php';</script>"; 
            } 
            mysqli_close($conn);
	
	}

	// retrieve/read/display records
	$results = mysqli_query($conn, "SELECT * FROM car");
?>