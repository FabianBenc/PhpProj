<?php
    if(isset($_GET["patientID"]) && !empty(trim($_GET["patientID"])))
    {
        require_once "config.php";

        $sql = "SELECT * FROM patients WHERE patientID = ?";

        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = trim($_GET["patientID"]);

            if(mysqli_execute($stmt))
            {
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1)
                {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $lastName = $row["lastName"];
                    $firstName = $row["firstName"];
                    $age = $row["age"];
                    $sex = $row["sex"];
                    $bloodType = $row["bloodType"];
                    $registrationDate = $row["registrationDate"];
                    $image = $row["image"];
                }
                else
                {
                    header("location: error.php");
                    exit();
                }
            }
            else
            {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

        mysqli_close($link);
    }
    else
    {
        header("location: error.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }

    * {margin: 0; padding: 0; box-sizing: border-box;}
    .spacer {width: 100%; height: 100px;}

    body {
    background-image: linear-gradient(-225deg, #fff 0%, #1b98e0 100%);
background-image: linear-gradient(to bottom, #fff 80%, #1b98e0 100%);
background-attachment: fixed;
  background-repeat: no-repeat;
opacity: .95;
}

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
<body style="background-color:#fbfbff">
<nav>
  <ul class="nav-bar">
	  <li class="nav-bar_item"><a class="logo" href="#">Logo</a></li>
    <li class="nav-bar_item"><a class="logo" href="Main.php">Home</a></li>
	  <li class="nav-bar_item"><a class="logo" href="about.php">about</a></li>
  </ul>
	<ul class="nav-bar">
		<li class="nav-bar_item"><a href="create.php" style="color:#B5F44A"><i class="fas fa-user-plus" style="color:#B5F44A"></i> Add New Patient</a></li>
		<li class="nav-bar_item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
	</ul>
</nav>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p><b><?php echo $row["lastName"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <p><b><?php echo $row["firstName"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Picture</label>
                        <p><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image'])?>" onerror="this.src='user_1.png'" width='200' height='200' /></p>
                    </div>
                    <p><a href="Main.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>