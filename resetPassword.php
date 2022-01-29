<?php 

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: Main.php");
    exit;
}

require_once "config.php";

$newPassword = $confirmPassword = "";
$newPasswordError = $confirmPasswordError = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["newPassword"])))
    {
        $newPasswordError = "Please enter password.";
    }
    elseif(strlen(trim($_POST["newPassword"])) < 4)
    {
        $newPasswordError = "Password must be at least 4 characters.";
    }
    else
    {
        $newPassword = trim($_POST["newPassword"]);
    }
    if(empty(trim($_POST["confirmPassword"])))
        {
            $confirmPasswordError = "Please confirm the password";
        }
        else
        {
            $confirmPassword = trim($_POST["confirmPassword"]);
            if(empty($newPasswordError) && ($newPassword != $confirmPassword))
            {
                $confirmPasswordError = "Password did not match.";
            }
        }
    if(empty($newPasswordError) && empty($confirmPasswordError))
    {
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "si", $paramPassword, $paramId);

            $paramPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $paramId = $_SESSION["id"];

            if(mysqli_stmt_execute($stmt))
            {
                //session_destroy(); 
                echo "<script>alert('Password reset successful'); window.location = 'Main.php'</script>";  
                //header("location: Main.php");
                //exit();
            }
            else
            {
                echo "Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <title>Reset Password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <style>
    * {margin: 0; padding: 0; box-sizing: border-box;}
    .spacer {width: 100%; height: 100px;}

    body {
        background-image: linear-gradient(-225deg, #fff 0%, #1b98e0 100%);
    background-image: linear-gradient(to bottom, #fff 80%, #1b98e0 100%);
    background-attachment: fixed;
    background-repeat: no-repeat;
    opacity: .95;
    }
    body {font-family: "Open Sans", sans-serif;}
    nav {
        width: 100%; 
        background-color: #1b98e0; 
        display: flex;
        justify-content: space-between;
    position: fixed;
    top:0;
    }
    .logo {
        padding: 0px; 
        text-decoration: none;
        color: #fff;
        text-transform: uppercase;
        font-size: 25px;
    }
    nav .nav-bar {
        padding: 0px; 
        display: flex;
    }
    nav .nav-bar .nav-bar_item {
        list-style-type: none;
        padding-right: 20px;
    padding-top: 15px;
    font-size: 25px;
    }
    nav .nav-bar .nav-bar_item a {
        position: relative;
        display: block; 
        padding-bottom: 2px;
        text-decoration: none;
        color: #fff;
    }
    nav .nav-bar .nav-bar_item a:after {
        content: "";
        position: absolute;
        width: 0%;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #fff;
        transition: 0.1s ease-in-out;
    }
    nav .nav-bar .nav-bar_item a:hover:after {
        width: 100%;
    }
    </style>
    <body style="background-color:#fbfbff">
        <nav>
          <ul class="nav-bar">
              <li class="nav-bar_item"><a class="logo" href="Main.php"><i class="fas fa-heartbeat"></i> EHR</a></li>
              <li class="nav-bar_item"><a class="logo" href="about.html">about</a></li>
          </ul>
            <ul class="nav-bar">
                <li class="nav-bar_item"><a href="create.php" style="color:#B5F44A"><i class="fas fa-user-plus" style="color:#B5F44A"></i> Add New Patient</a></li>
                <li class="nav-bar_item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
            </ul>
        </nav>
<script>
function showAlert() 
{
    var myText = "Password reset sucessful";
    alert (myText);
}

function showPassword() 
{
    var x = document.getElementsByClassName("password-input");
if (x[0].type === "password") 
{
    x[0].type = "text";
    x[1].type = "text";
} else 
{
    x[0].type = "password";
    x[1].type = "password";
}
}
</script>

    <div class = "mx-5">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class = "mx-5">
            <label for="inputNewPassword" class="form-label">New Password</label>
            <input type="password" id="inputNewPassword" name="newPassword" aria-describedby="newPasswordHelp" class="form-control <?php
        echo (!empty($newPasswordError)) ? ' is-invalid' : ''; ?><?php echo $newPassword; ?> password-input">
        <span class = "invalid-feedback"><?php echo $newPasswordError; ?></span>
    </div>
    <div class = "mx-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class = "mx-4">
            <label for="confirmNewPassword" class="form-label">Confirm Password</label>
            <input type="password" id="confirmNewPassword" name="confirmPassword" aria-describedby="confirmPasswordHelp" class="form-control <?php
        echo (!empty($confirmPasswordError)) ? ' is-invalid' : ''; ?><?php echo $confirmPasswordError; ?> password-input">
        <span class = "invalid-feedback"><?php echo $confirmPasswordError; ?></span>
    </div>
    <div class="form-group mx-4">
        <input type="checkbox" onclick="showPassword()"> Show Password <br></br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class = "btn btn-link ml-2" href="Main.php">Cancel</a>
    </div>
    </form>
</html>