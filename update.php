<?
    require_once "config.php";

    session_start();
    $firstName = $lastName = $age = $sex = $bloodType = $registrationDate = "";
    $firstNameError = $lastNameError = $ageError = $sexError = $bloodTypeError = $regDateError = "";

    if(isset($_POST["patientID"]) && (!empty($_POST["patientID"])))
    {
        $id = $_POST["patientID"];

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
            $sql = "UPDATE patients SET lastName=?, firstName=?, age=?, sex=?, bloodType=?, registrationDate=? WHERE patientID=?";

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
    else
    {
        if(isset($_GET['patientID']) && !empty(trim($_GET['patientID'])))
        {
            $id = trim($_GET['patientID']);

            $sql = "SELECT * FROM patients WHERE patientID =?";
            if($stmt = mysqli_prepare($link,$sql))
            {

                if(mysqli_num_rows($result) ==1)
                {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                    $lastName = $row["lastName"];
                    $firstName = $row["lastName"];
                    $age = $row["age"];
                    $sex = $row["sex"];
                    $bloodType = $row["bloodType"];
                    $registrationDate = $row["registrationDate"];
                }
                else
                {
                    header("location: error.php");
                    exit();
                }
            }
            else
            {
                echo "Somethin went wrong.";
            }
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }
        else
        {
            echo "Something went wrong.";
        }
    }
?>

