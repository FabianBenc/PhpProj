<?php

require_once "config.php";
session_start();
$firstName = $lastName = $age = $sex = $bloodType = $registrationDate = "";
$firstNameError = $lastNameError = $ageError = $sexError = $bloodTypeError = $regDateError = "";


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $inputName = trim($_POST["firstName"]);
    if(empty($inputName))
    {
        $firstNameError = "Please enter patients' first name.";
    }
    elseif(!filter_var($inputName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $firstNameError = "Please enter a valid first name.";
    }
    else
    {
        $firstName = $inputName;
    }

    $inputLName = trim($_POST["lastName"]);
    if(empty($inputLName))
    {
        $lastNameError = "Please enter patients' last name.";
    }
    elseif(!filter_var($inputLName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $lastNameError = "Please enter a valid last name.";
    }
    else
    {
        $lastName = $inputLName;
    }

    $inputAge = trim($_POST["age"]);
    if(empty($inputAge))
    {
        $ageError = "Please enter patients' age.";
    }
    elseif(!ctype_digit($inputAge))
    {
        $ageError = "Please enter a positive integer value.";
    }
    else
    {
        $age = $inputAge;
    }

    if(isset($_POST['sex']))
    {
        $sex = $_POST['sex'];
    }
    else
    {
        $sexError = "You must choose patient's sex.";
    }

    if(isset($_POST['bloodType']))
    {
        $bloodType = $_POST['bloodType'];
        
    }
    else
    {
        $bloodTypeError = "You must choose patient's blood type.";
    }

    $inputregistrationDate = trim($_POST["registrationDate"]);
    if(empty($inputregistrationDate))
    {
        $regDateError = "Please enter a valid registration date.";
    }
    else
    {
        $registrationDate = $inputregistrationDate;
    }

    if(empty($firstNameError) && empty($lastNameError) && empty($ageError)  && empty($regDateError) && empty($sexError) && empty($bloodTypeError))
    {
        $sql = "INSERT INTO patients (lastName, firstName, age, sex, bloodType, registrationDate, id) VALUES (?, ?, ?, ?, ?, ?, {$_SESSION['id']}) ";

        if($stmt = mysqli_prepare($link, $sql))
        {
            //bind variables to the perapred statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $lastName, $firstName, $age, $sex, $bloodType, $registrationDate);

            if(mysqli_stmt_execute($stmt))
            {
                header("location: Main.php");
                exit();
            }
            else
            {
                echo "Something went wrong.";
            }
        }

        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Add new Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<style>
* {margin: 0; padding: 0; box-sizing: border-box;}
.spacer {width: 100%; height: 100px;}

body {font-family: "Open Sans", sans-serif;}

nav {
	width: 100%; 
	background-color: #1b98e0; 
	display: flex;
	justify-content: space-between;
}
.logo {
	padding: 0px; 
	text-decoration: none;
	color: #fff;
	text-transform: uppercase;
}
nav .nav-bar {
	padding: 0px; 
	display: flex;
}
nav .nav-bar .nav-bar_item {
	list-style-type: none;
	padding-right: 20px;
  padding-top: 15px;
}
nav .nav-bar .nav-bar_item a {
	position: relative;
	display; block; 
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

<body>
<nav>
  <ul class="nav-bar">
	  <li class="nav-bar_item"><a class="logo" href="#">Logo</a></li>
    <li class="nav-bar_item"><a class="logo" href="Main.php">Home</a></li>
	  <li class="nav-bar_item"><a class="logo" href="about.php">about</a></li>
  </ul>
	<ul class="nav-bar">
		<li class="nav-bar_item"><a href="create.php" hidden>Add New Patient</a></li>
		<li class="nav-bar_item"><a href="logout.php">logout</a></li>
	</ul>
</nav>
    <br>
    <div class="mx-5"><p>Create Patient Record</p></div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="mx-5">
        <label for="inputlastName" class="form-label">Last Name</label>
        <input type="lastName" id="inputlastName" name="lastName" aria-describedby="lastNameHelp" class="form-control <?php
        echo (!empty($lastNameError)) ? ' is-invalid' : ''; ?><?php echo $lastName; ?>">
        <div id="lastNameHelp" class="form-text">Please enter Patients' last name.</div>
        <span class = "invalid-feedback"><?php echo $lastNameError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputfirstName" class="form-label">First Name</label>
        <input type="firstName" id="inputfirstName" name="firstName" aria-describedby="firstNameHelp" class="form-control <?php
        echo (!empty($firstNameError)) ? ' is-invalid' : ''; ?><?php echo $firstName; ?>">
        <div id="firstNameHelp" class="form-text">Please enter Patients' first name.</div>
        <span class = "invalid-feedback"><?php echo $firstNameError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputAge" class="form-label">Age</label>
        <input type="age" id="inputAge" name="age" aria-describedby="ageHelp" class="form-control <?php
        echo (!empty($ageError)) ? ' is-invalid' : ''; ?><?php echo $age; ?>">
        <div id="confirmPasswordHelp" class="form-text">Please enter Patients' age.</div>
        <span class = "invalid-feedback"><?php echo $ageError; ?></span>
    </div>
    <div class="mx-5">
    <label for="inputSex" class="form-label">Sex</label><br>
        <input type="radio" id="sex" name="sex" value="Male" class="form-radio
        <?php
        echo (!empty($sexError)) ? ' is-invalid' : ''; ?><?php echo $sex; ?>">
        <label for="Male">Male</label><br>
        <input type="radio" id="sex" name="sex" value="Female" class="form-radio
        <?php
        echo (!empty($sexError)) ? ' is-invalid' : ''; ?><?php echo $sex; ?>">
        <label for="Female">Female</label><br>
        <div id="sexHelp" class="form-text">Please enter Patients' sex.</div>
        <span class = "invalid-feedback"><?php echo $sexError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputbloodType" class="form-label">Blood Type</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="A" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : ''; echo $selectedRadio;?><?php echo $bloodType; ?>">
        <label for="A">A</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="B" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : ''; ?><?php echo $bloodType; ?>">
        <label for="B">B</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="AB" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : ''; ?><?php echo $bloodType; ?>">
        <label for="AB">AB</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="0" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : ''; ?><?php echo $bloodType; ?>">
        <label for="0">0</label><br>
        <div id="bloodTypeHelp" class="form-text">Please choose Patients' Blood Type.</div>
        <span class = "invalid-feedback"><?php echo $bloodTypeError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputregistrationDate" class="form-label">Registration Date</label>
        <input type="datetime-local" id="inputregistrationDate" name="registrationDate" aria-describedby="registrationDateHelp" class="form-control <?php
        echo (!empty($regDateError)) ? ' is-invalid' : ''; ?><?php echo $registrationDate; ?>">
        <div id="registrationDateHelp" class="form-text">Please enter Patients' Registration Date.</div>
        <span class = "invalid-feedback"><?php echo $regDateError; ?></span>
    </div>
        <div class="form-group mx-5">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class = "btn btn-link ml-2" href="Main.php">Cancel</a>
    </div>
</body>
</form>
</html>