<?php
session_start();
$_SESSION['Logged In'] = false;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjectPHP";

$UserName = $_POST["UserName"];
$Password = $_POST["Password"];
$_SESSION['UserName'] = $UserName;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // $conn = new PDO("mysql:host=$servername", $username, $password);
    // $sql = "CREATE DATABASE ProjectPHP";

    // $conn->exec("DELETE FROM Users");
    // $conn->exec("ALTER TABLE Users AUTO_INCREMENT = 1");

    $stm = $conn->prepare("SELECT * FROM Validation WHERE username = :username");
    $stm->bindParam(':username', $UserName);
    $stm->execute();

    $row = $stm->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // User found, verify password
        if (password_verify($Password, $row['password'])) {
            echo "Login successful!";
            $_SESSION['Logged In'] = true;
            header('Location: ../Index.php');
        } else {
            echo "Incorrect password. Please try again";
            echo '<br><a href="../Index.php">Home</a>';
            echo '<br>Forgot your password? Change it.';
            echo '<br><a href="../Edit/edit.html">Reset Password</a>';
        }
    } else {
        echo "Username not found.";
        echo '<br><a href="../Index.php">Try Again!</a>';
    }

    // Display all users
    // $stmt = $conn->query("SELECT * FROM Users");
    // $allRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo "<br><br>All Users:<br>";
    // echo "<table border='1'>";
    // echo "<tr><th>ID</th><th>Username</th><th>Password</th></tr>";
    // foreach ($allRows as $row) {
    //     echo "<tr><td>".$row['user_id']."</td><td>".$row['username']."</td><td>".$row['password']."</td></tr>";
    // }
    // echo "</table>";
} catch (PDOException $e) {
    echo "<br>" . $e->getMessage();
}
$conn = null;
?>
