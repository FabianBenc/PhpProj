<!DOCTYPE html>
<html>
<head>
<title>Main Page</title>
<meta charset = "UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<style>
  <?php  session_start();  ?>
* {margin: 0; padding: 0; box-sizing: border-box;}
.spacer {width: 100%; height: 100px;}

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
.table-row{
cursor:pointer;
}
.button2 {
  background-color: #f3faff; 
  color: black; 
  border: 2px solid #008CBA;
  border-radius: 10px;
  padding: 5px;
  width: 100%;
}
.imgcenter {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
body {
    background-image: linear-gradient(-225deg, #fff 0%, #1b98e0 100%);
background-image: linear-gradient(to bottom, #fff 80%, #1b98e0 100%);
background-attachment: fixed;
  background-repeat: no-repeat;
opacity: .95;
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
<div class="row">
<div class="col-2" style="background-color:#f3faff; height:520px; margin-left:30px; margin-top: 80px; margin-right:10px; border-style:solid; border-color:#1b98e0; box-shadow: 5px 5px 5px lightblue; border-radius:10px;position:fixed;">
  <h2 style="text-align: center;"> Hello <?php echo $_SESSION["username"];?> </h2>
  <p><img src="user_1.png" class="imgcenter"/></p>
  <button class="button button2"><b><a class ="card1" href="resetPassword.php"><i class="fas fa-cogs"></i> Reset Password</a></b></button><br>
</div>

<?php
  require_once "config.php";
  //require_once "delete.php";
  //require_once "error.php";
  //dodaj anti lesar statemente
  if (isset($_GET['page_no']) && $_GET['page_no']!="") 
  {
    $page_no = $_GET['page_no'];
  }
  else 
  {
    $page_no = 1;
  }
  $total_records_per_page = 10;
  $offset = ($page_no-1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = "2"; 

  $result_count = mysqli_query(
    $link,
    "SELECT COUNT(*) As total_records FROM `patients` WHERE {$_SESSION['id']} = id"
    );
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total pages minus 1

  $sql = "SELECT * FROM patients WHERE {$_SESSION['id']} = id  LIMIT $offset, $total_records_per_page";

  if($result = mysqli_query($link,$sql))
  {
    if(mysqli_num_rows($result) >= 0)
    {
      echo "<br>";
      echo "<div id='table'class='col-9' style='max-width: 85%'; 'overflow-y = auto';>";
      echo '<table class = "table rounded-3 text-center table-responsive table-rounded  table-hover" style="background-color: #f3faff; margin-top: 80px; border-color:#1b98e0; font-size: 20px; font-weight: bold; margin-left: 380px;">';
        echo '<thead>';
            echo '<tr>';
            echo '<th>Patient ID</th>';
            //echo '<th>Image</th>';
            echo '<th>Last Name</th>';
            echo '<th>First Name</th>';
            echo '<th>Age</th>';
            echo '<th>Sex</th>';
            echo '<th>Blood Type</th>';
            echo '<th>Registration Date</th>';
            echo '<th>Options</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';
          echo '</div>';
            while($row = mysqli_fetch_array($result))
            {
              echo '<tr class="table-row" data-href="read.php?patientID='. $row['patientID'] .'" style="text-align: center; vertical-align: middle;">';
                echo '<td>' . $row['patientID'] . '</td>';
                //echo '<td><img src="data:image/jpg;charset=utf8;base64,' . base64_encode($row['image']) . '" style="border-radius: 50%; height: 50px; width: 50px;"></td>';
                echo '<td>' . $row['lastName'] . '</td>';
                echo '<td>' . $row['firstName'] . '</td>';
                echo '<td>' . $row['age'] . '</td>';
                echo '<td>' . $row['sex'] . '</td>';
                echo '<td>' . $row['bloodType'] . '</td>';
                echo '<td>' . $row['registrationDate'] . '</td>';
                //echo '<td>' . $row['id'] . '</td>';
                echo '<td><a href="delete.php?patientID='. $row['patientID'].'"><i class="fas fa-user-minus" title="Delete patient record" style="color:red"></i></a> <a href="update.php?patientID='. $row['patientID'] .'"><i class="fas fa-user-edit" title=" Update patient record"style="color:#FF9B54"></i></a> <a href="read.php?patientID='. $row['patientID'] .'"><i class=" fas fa-solid fa-book-medical" title="Read patient record"></i></a></td>';
              echo '</tr>';
            }
          echo '</tbody>';
      echo '</table>';
      mysqli_free_result($result);
    }
  }
mysqli_close($link);
//session_start();
//$NAME=$_SESSION['id'];
//echo "Name is ".$NAME;
//echo $_SESSION['id'];
?>
<div style='padding: 10px 20px 0px; border-top: dotted 2px #CCC; margin-left:390px; max-width:74%;'>
    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
<ul class="pagination">
<?php if($page_no > 1){
echo "<li class='page-item'><a class='page-link' href='?page_no=1'>First Page</a></li>";
} ?>
    
<li class='page-item' <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a class='page-link'<?php if($page_no > 1){
echo "href='?page_no=$previous_page'";
} ?>>Previous</a>
</li>
    
<li class='page-item'<?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a class='page-link'<?php if($page_no < $total_no_of_pages) {
echo "href='?page_no=$next_page'";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>
</div>
<script>
  $(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>
</body>
</html>