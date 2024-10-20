<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjectPHP";

$UserName = trim($_POST["username"]);
$fName = trim($_POST["firstname"]);
$lName = trim($_POST["lastname"]);
$NewPassword = trim(password_hash($_POST["password"], PASSWORD_DEFAULT));

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stm = $conn->prepare("SELECT * FROM Validation WHERE username = :username");
    $stm->bindParam(':username', $UserName);
    $stm->execute();

    $row = $stm->fetch(PDO::FETCH_ASSOC);

    if ($row){
        $stmA = $conn->prepare("SELECT user_id FROM Validation WHERE username = :username");
        $stmA->bindParam(':username', $UserName);
        $stmA->execute();

        $userID = $stmA->fetch(PDO::FETCH_ASSOC);

        $stmB = $conn->prepare("SELECT user_id FROM Users WHERE firstname = :firstname AND lastname = :lastname");
        $stmB->bindParam(':firstname', $fName);
        $stmB->bindParam(':lastname', $lName);
        $stmB->execute();

        $namesID = $stmB->fetch(PDO::FETCH_ASSOC);

        if($userID == $namesID){
           $stmE = $conn->prepare("UPDATE Validation SET password = :password WHERE username = :username");
           $stmE->bindParam(':password',$NewPassword);
           $stmE->bindParam(':username', $UserName);
           
           $stmE->execute();
           echo "Password reset!";
           echo '<br><a href="../LogIn/LogIn.html"><button type = "button">Log In</button></a>';
        }
        else {
            echo "Identification not match. Please try again!";
        }
    }
    else{
        echo"No accounts with username found.";
    }


} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

