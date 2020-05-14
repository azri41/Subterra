<?php
session_start();
// require "header.php";


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["usertype"] === 'Customer'){
        header("location: UserMain.php");
        exit;
    }
    elseif($_SESSION["usertype"] === 'Staff'){
        header("location: StaffMain.php");
        exit;
    }
    elseif($_SESSION["usertype"] === 'Admin'){
        header("location: AdminMain.php");
        exit;
    }
}
require "Config.php";
$username = $password = $usertype = "";
$username_err = $password_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    }
    else{
        $username = trim(($_POST["username"]));
    }

    //check for empty password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    }
    else if(strlen(trim($_POST["password"])) < 6){
        $password_err= "Please enter minimum 6 character.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    //look for username+password combo in database
    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT username, password, usertype FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                //1 means username exists, not 1 is wrong username
                if(mysqli_stmt_num_rows($stmt) == 1){

                    mysqli_stmt_bind_result($stmt, $username, $hash, $usertype);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password,$hash)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["usertype"] = $usertype;

                            if($usertype === 'Customer'){
                                header("location: DetailsForm.php"); 
                            } 
                            else if($usertype === 'Staff'){
                                header("location: StaffMain.php");
                            }
                            else if($usertype === 'Admin'){
                                header("location: AdminMain.php");
                            }
                        }
                        else{
                            //in case of wrong password
                            $password_err = "The password you entered was not valid.";
                        }
                    }

                }
                else{
                    //in case of wrong username
                    $username_err = "No user found with that username.";
                }
            }
            else{
                //mysql server offline or other errors
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="wrapper-login">
        <h2>Login</h2>
        <p>Please fill in the form to login.</p>  
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" maxlength="50" value="<?php echo $username; ?>">
                <span class="help-block"><font color="red"><?php echo $username_err; ?></font></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><font color="red"><?php echo $password_err; ?></font></span>
            </div>
            <div class="button">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account ? <a href="RegisterCustomer.php">Sign up now!</a></p>
        </form>
    </div>
</body>
</html>