<?php
require_once "config.php";

$username = $password = $confirmPassword = "";
$usernameError = $passwordError = $confirmPasswordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(trim($_POST["username"])))
    {
        $usernameError = "Please enter a username.";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
    {
        $usernameError = "Username can only contain letters, numbers, and underscores.";
    }
    else
    {
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link,$sql))
        {
            mysqli_stmt_bind_param($stmt,"s",$param_username);

            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
            }

            if (mysqli_stmt_num_rows($stmt) == 1)
            {
                $usernameError = "This username is already taken.";
            }
            else
            {
                $username = trim($_POST["username"]);
            }
        }
        else
        {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    
    if(empty(trim($_POST["password"])))
    {
        $passwordError = "Please enter password.";
    }
    elseif(strlen(trim($_POST["password"])) < 4)
    {
        $passwordError = "Password must have at least 4 characters.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"])))
    {
        $confirmPasswordError = "Please confirm password.";
    }
    else
    {
        $confirmPassword = trim($_POST["confirm_password"]);
        if(empty($passwordError) && ($password != $confirmPassword))
        {
            $confirmPasswordError = "Password did not match.";
        }
    }
    if(empty($usernameError) && empty($passwordError) && empty($confirmPasswordError))
    {
        $sql = "INSERT INTO users(username, password) VALUES (?,?)";

        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else
            {
                echo "Something went wrong";
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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="container">
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="mb-3">
        <label for="inputUsername" class="form-label">Username</label>
        <input type="username" id="inputUsername" name="username" aria-describedby="usernameHelp" class="form-control <?php
        echo (!empty($usernameError)) ? ' is-invalid' : ''; ?><?php echo $username; ?>">
        <div id="usernameHelp" class="form-text">Please enter your username.</div>
        <span class = "invalid-feedback"><?php echo $usernameError; ?></span>
    </div>
    <div class="mb-3">
        <label for="inputPassword" class="form-label">Password</label>
        <input type="password" id="inputPassword" name="password" aria-describedby="passwordHelp" class="form-control <?php
        echo (!empty($passwordError)) ? ' is-invalid' : ''; ?><?php echo $password; ?>">
        <div id="passwordHelp" class="form-text">Please enter your password.</div>
        <span class = "invalid-feedback"><?php echo $passwordError; ?></span>
    </div>
    <div class="mb-3">
        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
        <input type="password" id="inputConfirmPassword" name="confirm_password" aria-describedby="confirmPasswordHelp" class="form-control <?php
        echo (!empty($confirmPasswordError)) ? ' is-invalid' : ''; ?><?php echo $confirmPassword; ?>">
        <div id="confirmPasswordHelp" class="form-text">Please confirm your password.</div>
        <span class = "invalid-feedback"><?php echo $confirmPasswordError; ?></span>
    </div>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <p1> Already have an account? <a href="login.php">Login here</a>.</p1>
    </form>
</body>
</html>
