<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["Type"] == "SignUp") {
        header("Location: ../SignUp/SignUp.html");
    } 
    elseif ($_POST["Type"] == "LogIn") {
        header("Location: ../LogIn/LogIn.html");
    }
    else{
        echo "Please select an option";
    }
}
?>
