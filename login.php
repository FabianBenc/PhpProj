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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
<style>
    @import url('https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Alegreya|Arima+Madurai|Dancing+Script|Dosis|Merriweather|Oleo+Script|Overlock|PT+Serif|Pacifico|Playball|Playfair+Display|Share|Unica+One|Vibur');
    
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body {
    background-image: linear-gradient(-225deg, #fff 0%, #1b98e0 100%);
background-image: linear-gradient(to bottom, #fff 0%, #1b98e0 100%);
background-attachment: fixed;
  background-repeat: no-repeat;
    font-family: 'Vibur', cursive;
    font-family: 'Abel', sans-serif;
opacity: .95;
}

form {
    width: 450px;
    min-height: 500px;
    height: auto;
    border-radius: 5px;
    margin: 2% auto;
    box-shadow: 0 9px 50px hsla(20, 67%, 75%, 0.31);
    padding: 2%;
    background-image: linear-gradient(-225deg, #fff 30%, #1b98e0 70%);
}

header h2 {
    font-size: 250%;
    font-family: 'Playfair Display', serif;
    color: #fff;
}

button {
    display: inline-block;
  
    width: 280px;
    height: 50px;
  
    padding: 0 20px;
    background: #fff;
    border-radius: 5px;
    
    outline: none;
    border: none;
  
    cursor: pointer;
    text-align: center;
    transition: all 0.2s linear;
    
    margin: 7% auto;
    letter-spacing: 0.05em;
}
.submits {
    width: 35%;
    display: inline-block;
    float: right;
    margin-left: 2%;
}
.sign-up {background: #f3faff;}

/* buttons hover */
button:hover {
    transform: translatey(3px);
    box-shadow: none;
}

/* buttons hover Animation */
button:hover {
    animation: ani9 0.4s ease-in-out infinite alternate;
}
@keyframes ani9 {
    0% {
        transform: translateY(3px);
    }
    100% {
        transform: translateY(5px);
    }
}
</style>
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
            <label for="inputUsername" class="form-label"><b>Username</b></label>
            <input placeholder="Username" type="username" id="inputUsername" name="username" aria-describedby="usernameHelp" class="form-control <?php
            echo (!empty($usernameError)) ? ' is-invalid' : ''; ?>">
            <div id="usernameHelp" class="form-text">Please enter your username.</div>
            <span class = "invalid-feedback"><?php echo $usernameError; ?></span>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label"><b>Password</b></label>
            <input  placeholder="Password" type="password" id="inputPassword" name="password" aria-describedby="passwordHelp" class="form-control <?php
            echo (!empty($passwordError)) ? ' is-invalid' : ''; ?>">
            <div id="passwordHelp" class="form-text">Please enter your password.</div>
            <span class = "invalid-feedback"><?php echo $passwordError; ?></span>
        </div>
        <div class="form-group">
            <input type="checkbox" onclick="showPassword()"> Show Password <br></br>
            <button type="submit" class="btn submits sign-up" value = "Login"><b>Login</b></button>
        </div><br><br><br><br><br>
    <p><b>Don't have an account? <a href="registration.php" style="color:white;"> Sign up now</a>.</b></p>
    </form>
</body>