<?php
require_once "config.php";
 
session_start();
    $firstName = $lastName = $age = $sex = $bloodType = $registrationDate = $bloodPressure = "";
    $firstNameError = $lastNameError = $ageError = $sexError = $bloodTypeError = $regDateError = $bloodPressureError ="";
 
if(!empty($_POST["patientID"])){
    $id = $_POST["patientID"];
    $image = file_get_contents($_FILES['image']['tmp_name']);
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

        $inputBloodPressure = trim($_POST["bloodPressure"]);
        if(empty($inputBloodPressure))
        {
            $bloodPressure = null;
        }
        elseif(!filter_var($inputBloodPressure, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d+(\/\d+)*$/"))))
        {
            $bloodPressureError = "Please enter a valid blood pressure";
        }
        else
        {
            $bloodPressure = $inputBloodPressure;
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
    
    if(empty($firstNameError) && empty($lastNameError) && empty($ageError)  && empty($regDateError) && empty($sexError) && empty($bloodTypeError) && empty($bloodPressureError))
        {
            $sql = "UPDATE patients SET lastName=?, firstName=?, age=?, sex=?, bloodType=?, bloodPressure=?, registrationDate=?, image=? WHERE patientID=?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssssssi", $lastName, $firstName, $age, $sex, $bloodType, $bloodPressure, $registrationDate, $image, $id);
            
            if(mysqli_stmt_execute($stmt)){
                header("location: Main.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} else{
    if(isset($_GET["patientID"]) && !empty(trim($_GET["patientID"]))){
        $id =  trim($_GET["patientID"]);
        
        $sql = "SELECT * FROM patients WHERE patientID = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $lastName = $row["lastName"];
                    $firstName = $row["firstName"];
                    $age = $row["age"];
                    $sex = $row["sex"];
                    $bloodType = $row["bloodType"];
                    $bloodPressure = $row["bloodPressure"];
                    $registrationDate = $row["registrationDate"];
                    $image = $row["image"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Update Patient</title>
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
	  <li class="nav-bar_item"><a class="logo" href="about.php">about</a></li>
  </ul>
	<ul class="nav-bar">
		<li class="nav-bar_item"><a href="create.php" style="color:#B5F44A"><i class="fas fa-user-plus" style="color:#B5F44A"></i> Add New Patient</a></li>
		<li class="nav-bar_item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
	</ul>
</nav>
    <div class="mx-5" style="margin-top: 65px;"><p>Update Patient Record</p></div>
    <form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post"  enctype="multipart/form-data">
    <div class="mx-5">
        <label for="inputlastName" class="form-label">Last Name</label>
        <input type="lastName" id="inputlastName" name="lastName" aria-describedby="lastNameHelp" class="form-control <?php
        echo (!empty($lastNameError)) ? ' is-invalid' : ''; ?>"value="<?php echo $lastName; ?>">
        <div id="lastNameHelp" class="form-text">Please enter Patients' last name.</div>
        <span class = "invalid-feedback"><?php echo $lastNameError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputfirstName" class="form-label">First Name</label>
        <input type="firstName" id="inputfirstName" name="firstName" aria-describedby="firstNameHelp" class="form-control <?php
        echo (!empty($firstNameError)) ? ' is-invalid' : ''; ?>"value="<?php echo $firstName; ?>">
        <div id="firstNameHelp" class="form-text">Please enter Patients' first name.</div>
        <span class = "invalid-feedback"><?php echo $firstNameError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputAge" class="form-label">Age</label>
        <input type="age" id="inputAge" name="age" aria-describedby="ageHelp" class="form-control <?php
        echo (!empty($ageError)) ? ' is-invalid' : ''; ?>"value="<?php echo $age; ?>">
        <div id="confirmPasswordHelp" class="form-text">Please enter Patients' age.</div>
        <span class = "invalid-feedback"><?php echo $ageError; ?></span>
    </div>
    <div class="mx-5">
    <label for="inputSex" class="form-label">Sex</label><br>
        <input type="radio" id="sex" name="sex" value="Male" class="form-radio
        <?php
        echo (!empty($sexError)) ? ' is-invalid' : ''; ?>"<?php echo strcmp($sex,"Male") == 0 ? 'checked' :'';?>>
        <label for="Male">Male</label><br>
        <input type="radio" id="sex" name="sex" value="Female" class="form-radio
        <?php
        echo (!empty($sexError)) ? ' is-invalid' : ''; ?>"<?php echo strcmp($sex,"Female") == 0 ? 'checked' :'';?>>
        <label for="Female">Female</label><br>
        <div id="sexHelp" class="form-text">Please enter Patients' sex.</div>
        <span class = "invalid-feedback"><?php echo $sexError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputbloodType" class="form-label">Blood Type</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="A" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : '';?>"<?php echo strcmp($bloodType,"A") == 0 ? 'checked' :'';?>>
        <label for="A">A</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="B" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : '';?>"<?php echo strcmp($bloodType,"B") == 0 ? 'checked' :'';?>>
        <label for="B">B</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="AB" class="form-radio <?php
       echo (!empty($bloodTypeError)) ? ' is-invalid' : '';?>"<?php echo strcmp($bloodType,"AB") == 0 ? 'checked' :'';?>>
        <label for="AB">AB</label><br>
        <input type="radio" id="bloodType" name="bloodType" value="0" class="form-radio <?php
        echo (!empty($bloodTypeError)) ? ' is-invalid' : '';?>"<?php echo strcmp($bloodType,"O") == 0 ? 'checked' :'';?>>
        <label for="O">O</label><br>
        <div id="bloodTypeHelp" class="form-text">Please choose Patients' Blood Type.</div>
        <span class = "invalid-feedback"><?php echo $bloodTypeError; ?></span>
    </div>
    <div class="mx-5">
    <label for="inputbloodPressure" class="form-label">Blood Pressure</label>
    <div class="input-group">
        <input type="bloodPressure" id="inputbloodPressure" name="bloodPressure" aria-describedby="bloodPressureHelp" class="form-control <?php
        echo (!empty($bloodPressureError)) ? ' is-invalid' : ''; ?>"value="<?php echo $bloodPressure; ?>"><div class="input-group-append">
        <span class="input-group-text"> mmHg </span></div>
    </div>
    <div id="bloodPressureHelp" class="form-text">Please enter Patients' Blood Pressure.</div>
        <span class = "invalid-feedback"><?php echo $bloodPressureError; ?></span>
    </div>
    <div class="mx-5">
        <label for="inputregistrationDate" class="form-label">Registration Date</label>
        <input type="datetime-local" id="inputregistrationDate" name="registrationDate" aria-describedby="registrationDateHelp" class="form-control <?php
        echo (!empty($regDateError)) ? ' is-invalid' : ''; ?>"value="<?php echo $registrationDate = date("Y-m-d\TH:i:s", strtotime($row['registrationDate'])); ?>">
        <div id="registrationDateHelp" class="form-text">Please enter Patients' Registration Date.</div>
        <span class = "invalid-feedback"><?php echo $regDateError; ?></span>
    </div>
    <div class="mx-5">
        <label for="uploadImage" class="form-label">Upload patients' image</label>
        <input type="file" id="uploadImage" name="image" aria-describedby="imageUploadHelp" class="form-control">
        <div id="registrationDateHelp" class="form-text">Please upload patients' image.</div>
    </div>
        <div class="form-group mx-5">
        <input type="hidden" name="patientID" value="<?php echo $id; ?>"/>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class = "btn btn-link ml-2" href="Main.php">Cancel</a>
    </div>
</body>
</form>
</html>

