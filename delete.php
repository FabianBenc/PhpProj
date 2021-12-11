<?php
if(isset($_POST['patientID']) && !empty($_POST['patientID']))
{
    require_once "config.php";

    $sql = "DELETE FROM patients WHERE patientID = ?";

    if($stmt = mysqli_prepare($link, $sql))
    {
        mysqli_stmt_bind_param($stmt, "i", $paramid);

        $paramid = trim($_POST["patientID"]);

        if(mysqli_stmt_execute($stmt))
        {
            header("location: Main.php");
            exit();
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
    if(empty(trim($_GET["patientID"])))
    {
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Delete Patient Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
		<li class="nav-bar_item"><a href="create.php" hidden><i class="fas fa-user-plus"></i>Add New Patient</a></li>
		<li class="nav-bar_item"><a href="logout.php">logout</a></li>
	</ul>
</nav>
    <br>
    <div class="mx-5"><p>Delete Patient Record</p></div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="alert alert-danger">
        <input type="hidden" name="patientID" value="<?php echo trim($_GET["patientID"]); ?>"/>
            <p>Are you sure you want to delete this patient record?</p>
            <p>
            <input type="submit" value="Yes" class="btn btn-danger">
            <a href="Main.php" class="btn btn-secondary">No</a>



