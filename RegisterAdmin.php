<?php
session_start();
require "Config.php";

$username = $password =  "";
$usertype = "Admin";
$username_err = $password_err = $confirm_password_err =$check_err = "";

//get data from form after submission
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"])))
        $username_err = "Please enter a username.";
    else{
        //sql statement prep to check for existing username
        $sql = "SELECT username FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            //Bind variables to prepped statement
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //assigning value to to parameters
            $param_username = trim($_POST["username"]);

            //execute sql statement (if valid)
            if(mysqli_stmt_execute($stmt)){

                //store result to manipulate
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1)
                    $username_err = "An account with this username already exists.";
                else
                    $username = trim($_POST["username"]);
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    //password stuff
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    }
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must be at least 6 characters.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    //confirm the password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }

    //check for errors before modifying database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users (username, password, usertype) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_user);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_user=$usertype;

            if(mysqli_stmt_execute($stmt)){
                echo "<script>alert('Registration successful. Now you can login.');window.location.href='Login.php';</script>"; 
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
    <head><link rel="icon" href="img/car.ico">
        <meta charset="UTF-8">
        <title>Car Rental Management System</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <div class="wrapper-register">
        <h2>Register New Admin</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" maxlength="50" value="<?php echo $username; ?>">
                <span class="help-block"><font color="red"><?php echo $username_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><font color="red"><?php echo $password_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" autocomplete="off" class="form-control">
                <span class="help-block"><font color="red"><?php echo $confirm_password_err; ?></font></span>
            </div>
            <div class="form-group">
            <h2><?php echo $check_err; ?><h2>
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
        <a href="index.php"><button style="border-radius: 5px; padding: 5px 5px; text-align: center; background-color:red; color: white; font-family: 'Franklin Gothic Medium'; font-size: 17px;">Cancel</button></a>
    </div>
    </body></html>
    