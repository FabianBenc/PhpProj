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

                    $patientID = $row["patientID"];
                    $lastName = $row["lastName"];
                    $firstName = $row["firstName"];
                    $age = $row["age"];
                    $sex = $row["sex"];
                    $bloodType = $row["bloodType"];
                    $registrationDate = $row["registrationDate"];
                    $bloodPressure = $row["bloodPressure"];
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
.card1 {
  padding: 0px; 
	text-decoration: none;
	color: black;
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
	  <li class="nav-bar_item"><a class="logo" href="Main.php"><i class="fas fa-heartbeat"></i> EHR</a></li>
	  <li class="nav-bar_item"><a class="logo" href="about.php">about</a></li>
  </ul>
	<ul class="nav-bar">
		<li class="nav-bar_item"><a href="create.php" style="color:#B5F44A"><i class="fas fa-user-plus" style="color:#B5F44A"></i> Add New Patient</a></li>
		<li class="nav-bar_item"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a></li>
	</ul>
</nav>
</head>
<body>
<section style="margin-top: 80px;">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']) ?>" onerror="this.src='user_1.png';this.onerror='';" alt="avatar" class="rounded-circle img-fluid" style="width: 250px;">
            <h5 class="my-3">Patient</h5>
            <p class="text-muted mb-1"><b><?php echo $row["firstName"]; ?></b></p>
            <p class="text-muted mb-4"><b><?php echo $row["lastName"]; ?></b></p>
            <div class="d-flex justify-content-center mb-2">
            <a href="update.php?patientID=<?php echo $row['patientID'] ?>" class="btn btn-primary" style="margin-right:10px;">Edit</a>
              <a href="Main.php" class="btn btn-primary">Back</a>
            </div>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                
                <p class="mb-0">https://mdbootstrap.com</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                
                <p class="mb-0">mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                
                <p class="mb-0">@mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
              
                <p class="mb-0">mdbootstrap</p>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                
                <p class="mb-0">mdbootstrap</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">First Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["firstName"]; ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Last Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["lastName"]; ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Age</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["age"]; ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Sex</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["sex"]; ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Blood Type</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["bloodType"]; ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Blood Pressure</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["bloodPressure"]; ?> mmHG</b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Registration Date</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo $row["registrationDate"]; ?></b></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card mb-4 ">
              <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1"></span> Comments</p>
                <div  style="height: 5px;">
                  <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>