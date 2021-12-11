<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: Main.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$usernameError = $passwordError = $loginError = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["username"])))
    {
        $usernameError = "Please enter username.";
    }
    else
    {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"])))
    {
        $passwordError = "Please enter your password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    if(empty($usernameError) && empty($passwordError))
    {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link,$sql))
        {
            mysqli_stmt_bind_param($stmt, "s", $paramUsername);
        

            $paramUsername = $username;

            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashedPassword);
                    
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashedPassword))
                        {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;


                            header("location: Main.php");
                        }
                        else
                        {
                            $loginError = "Invalid username or password.";
                        }
                    }
                }
                else
                {
                    $loginError = "Invalid username or password.";
                }
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
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<script>
function showPassword() 
{
    var x = document.getElementById("inputPassword");
if (x.type === "password") 
{
    x.type = "text";

} else 
{
    x.type = "password";
}
}
</script>
<body class = "container">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>

    <?php
    if(!empty($loginError))
    {
        echo '<div class = "alert alert-danger">' . $loginError . '</div>';
    }
    ?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
        <div class = "mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="username" id="inputUsername" name="username" aria-describedby="usernameHelp" class="form-control <?php
            echo (!empty($usernameError)) ? ' is-invalid' : ''; ?>">
            <div id="usernameHelp" class="form-text">Please enter your username.</div>
            <span class = "invalid-feedback"><?php echo $usernameError; ?></span>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" id="inputPassword" name="password" aria-describedby="passwordHelp" class="form-control <?php
            echo (!empty($passwordError)) ? ' is-invalid' : ''; ?>">
            <div id="passwordHelp" class="form-text">Please enter your password.</div>
            <span class = "invalid-feedback"><?php echo $passwordError; ?></span>
        </div>
        <div class="form-group">
            <input type="checkbox" onclick="showPassword()"> Show Password <br></br>
            <button type="submit" class="btn btn-primary" value = "Login" >Login</button>
        </div>
    <p>Don't have an account? <a href="registration.php"> Sign up now</a>.</p>
    </form>
</body>