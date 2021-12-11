<?php
    require_once "config.php";

    $id = $_GET['patientID'];
    $sql = "DELETE FROM patients WHERE patientID = ?";

    if($stmt = mysqli_prepare($link, $sql))
    {
        //bind variables to the perapred statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $id);

        if(mysqli_stmt_execute($stmt))
        {
            header("location: Main.php");
            exit();
        }
        else
        {
            header("location: error.php");
            exit();
        }
    }
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

