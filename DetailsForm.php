<?php
    session_start();
    require "Config.php";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: Login.php");
    exit;
}

$filled = "";
$user = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$user'";
        if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $users_id=$row['users_id'];    
            }
        // Free result set
        mysqli_free_result($result);
        }
    }

    $query = "SELECT * FROM customer WHERE users_id='$users_id'";
    if($result = mysqli_query($conn, $query)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $filled=$row['filled'];    
            }
        // Free result set
        mysqli_free_result($result);
        }
    }

if($filled == 1)
{
    header('location: UserMain.php');
}
    
    $ic_no = $cust_name = $email =$phone_no= "";
    $ic_err = $cust_name_err =$email_err = $phone_no_err = $check_err = "";

    //get data from form after submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["ic_no"]))
    {
        if(empty(trim($_POST["ic_no"])))
            $ic_err = "Please enter your ic number.";
        else{
            //sql statement prep to check for existing ic no.
            $sql = "SELECT cust_id FROM customer WHERE ic_no = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "i", $param_ic);
    
                //assigning value to to parameters
                $param_ic = trim($_POST["ic_no"]);
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);
    
                    if(mysqli_stmt_num_rows($stmt) == 1)
                        $ic_err = "An account with this number already exists.";
                    else if(strlen($param_ic) < 0)
                        $ic_err = "Please enter positive number.";
                    else if(strlen($param_ic) > 14)
                        $phone_no_err = "Phone number must be at most 14 numbers.";
                    else if(!filter_var($param_ic, FILTER_VALIDATE_INT))
                        $ic_err = "You have entered invalid number.";
                    else
                        $ic_no = trim($_POST["ic_no"]);
                }
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
    
            mysqli_stmt_close($stmt);
        }
    }
    
        //name
        if(isset($_POST["cust_name"]))
    {
        if(empty(trim($_POST["cust_name"])))
            $cust_name_err = "Please enter your name.";

        else{
        $sql = "SELECT cust_id FROM customer WHERE cust_name = ?";
    
        if($stmt = mysqli_prepare($conn, $sql)){
            //Bind variables to prepped statement
            mysqli_stmt_bind_param($stmt, "s", $param_name);
    
            //assigning value to to parameters
            $param_name = trim($_POST["cust_name"]);
    
            //execute sql statement (if valid)
            if(mysqli_stmt_execute($stmt)){
    
                //store result to manipulate
                mysqli_stmt_store_result($stmt);

                $pattern = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';

                if(filter_var($param_name, FILTER_VALIDATE_INT))
                    $cust_name_err = "Please enter alphabet only.";
                else if(preg_match($pattern, $param_name)){
                    $cust_name_err = "Name cannot contain special characters.";
                }
                else
                    $cust_name = trim($_POST["cust_name"]);
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    
          mysqli_stmt_close($stmt);
        }
    }
    
        //email
        if(isset($_POST["email"]))
    {
        if(empty(trim($_POST["email"])))
            $email_err = "Please enter your email.";
        else{
            //sql statement prep to check for existing email.
            $sql = "SELECT cust_id FROM customer WHERE email = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "s", $param_email);
    
                //assigning value to to parameters
                $param_email = trim($_POST["email"]);
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);
    
                    if(mysqli_stmt_num_rows($stmt) == 1)
                        $email_err = "An account with this email already exists.";
                    else if(!filter_var($param_email, FILTER_VALIDATE_EMAIL))
                        $email_err = "Email is invalid.";
                    else
                        $email = trim($_POST["email"]);
                }
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
    
            mysqli_stmt_close($stmt);
        }
    }
    
        //phone number
        if(isset($_POST["phone_no"]))
    {
        if(empty(trim($_POST["phone_no"]))){
            $phone_no_err = "Please enter your phone number.";
        }
        
        else{
            //sql statement prep to check for existing phone number.
            $sql = "SELECT cust_id FROM customer WHERE phone_no = ?";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                //Bind variables to prepped statement
                mysqli_stmt_bind_param($stmt, "s", $param_phone_no);
    
                //assigning value to to parameters
                $param_phone_no = trim($_POST["phone_no"]);
    
                //execute sql statement (if valid)
                if(mysqli_stmt_execute($stmt)){
    
                    //store result to manipulate
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1)
                        $phone_no_err = "An account with this phone number already exists.";
                    else if(!is_numeric($param_phone_no))
                        $phone_no_err = "You have entered invalid number.";
                    else if(strlen(trim($_POST["phone_no"])) < 10)
                        $phone_no_err = "Phone number must be at least 10 numbers.";
                    else if(strlen(trim($_POST["phone_no"])) > 12)
                        $phone_no_err = "Phone number must be at most 12 numbers.";
                    else if(trim($_POST["phone_no"]) < 0)
                        $phone_no_err = "Please enter positive number.";
                    else
                        $phone_no = trim($_POST["phone_no"]);
                }
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
    
            mysqli_stmt_close($stmt);
        }
    }
        //check for errors before modifying database
        
        if(empty($ic_err) && empty($cust_name_err) && empty($email_err)&& empty($phone_no_err)){
            $username=$_SESSION['username'];
            echo $username;

            $sql = "SELECT * FROM users WHERE username='$username'";
            if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo $row['users_id'] ;
                    $users_id=$row['users_id'];    
                }
            // Free result set
            mysqli_free_result($result);
        }
    }   
            $filled = 1; //1 means it already fill the details
            $sql = "INSERT INTO customer (ic_no, cust_name, email, phone_no, users_id, filled) VALUES (?, ?, ?, ?, ?, '$filled')";
    
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "ssssi", $param_ic, $param_name, $param_email, $param_phone_no, $param_users_id );
                
                 $param_ic = $ic_no;
                 $param_name=$cust_name;
                 $param_email = $email;
                 $param_phone_no = $phone_no;
                 $param_users_id = $users_id;
    
                if(mysqli_stmt_execute($stmt)){
                    echo "<script>alert('Registration successful. Now you can continue.');window.location.href='UserMain.php';</script>"; 
                }
                else{
                    $check_err = "Something went wrong. Please try again later.";
                }
            }
            
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
}
?>
    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rental Management System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <div class="wrapper-register">
        <h2>Details</h2>
        <p>Please fill in this form to continue.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
            <div class="form-group <?php echo (!empty($ic_err)) ? 'has-error' : ''; ?>">
                <label>IC Number or Passport Number</label><br>
                <input type="text" name="ic_no" class="form-control" maxlength="12" value="<?php echo $ic_no; ?>" placeholder="Enter the number without (-) Example:123456789012">
                <span class="help-block"><font color="red"><?php echo $ic_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($cust_name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label><br>
                <input type="text" name="cust_name" class="form-control" maxlength="50" value="<?php echo $cust_name; ?>">
                <span class="help-block"><font color="red"><?php echo $cust_name_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label><br>
                <input type="text" name="email" class="form-control" maxlength="50" value="<?php echo $email; ?>" placeholder="Eg. abc@gmail.com">
                <span class="help-block"><font color="red"><?php echo $email_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($phone_no_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label><br>
                <input type="tel" name="phone_no" class="form-control" maxlength="15" minlength="10" value="<?php echo $phone_no; ?>" placeholder="Eg. 0123456789">
                <span class="help-block"><font color="red"><?php echo $phone_no_err; ?></font></span>
            </div>
            <div class="form-group">
            <h2><?php echo $check_err; ?><h2>
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <!-- <p>Already fill the details? <a href="UserMain.php">Continue to home page</a>.</p> -->
        </form>
    </div>

</body>
</html>