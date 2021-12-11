<!DOCTYPE html>
<html>
<head>
<title>Main Page</title>
<meta charset = "UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
<?php
  require_once "config.php";
  //require_once "delete.php";
  //require_once "error.php";
  session_start();
  //dodaj anti lesar statemente
  $sql = "SELECT * FROM patients WHERE {$_SESSION['id']} = id";
  if($result = mysqli_query($link,$sql))
  {
    if(mysqli_num_rows($result) >= 0)
    {
      echo "<br>";
      echo "<div id='table'class='mx-auto' style='width: 1000px'>";
      echo '<table class = "table rounded-3 text-center table-responsive table-bordered table-hover" style="background-color: #f3faff;">';
        echo '<thead>';
            echo '<tr>';
            echo '<th>Patient ID</th>';
            echo '<th>Last Name</th>';
            echo '<th>First Name</th>';
            echo '<th>Age</th>';
            echo '<th>Sex</th>';
            echo '<th>Blood Type</th>';
            echo '<th>Registration Date</th>';
            //echo '<th>Doctor ID</th>';
            //echo '<th>Delete</th>';
            //echo '<th>Update</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';
          echo '</div>';
            while($row = mysqli_fetch_array($result))
            {
              echo '<tr>';
                echo '<td>' . $row['patientID'] . '</td>';
                echo '<td>' . $row['lastName'] . '</td>';
                echo '<td>' . $row['firstName'] . '</td>';
                echo '<td>' . $row['age'] . '</td>';
                echo '<td>' . $row['sex'] . '</td>';
                echo '<td>' . $row['bloodType'] . '</td>';
                echo '<td>' . $row['registrationDate'] . '</td>';
                //echo '<td>' . $row['id'] . '</td>';
                echo '<td><a href="delete.php?patientID='. $row['patientID'].'"><i class="fas fa-user-minus" style="color:red"></i></a> <a href="update.php?patientID='. $row['patientID'] .'"><i class="fas fa-user-edit" style="color:#FF9B54"></i></a></td>';
              echo '</tr>';
            }
          echo '</tbody>';
      echo '</table>';
      mysqli_free_result($result);
    }
  }
mysqli_close($link);
//session_start();
?>
</body>
</html>