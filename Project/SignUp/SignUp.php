<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjectPHP";

$UserName = trim($_POST["username"]);
$fName = trim($_POST["firstname"]);
$lName = trim($_POST["lastname"]);
$Password = trim(password_hash($_POST["password"], PASSWORD_DEFAULT));

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // $conn->exec("DROP DATABASE $dbname");

    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE TABLE IF NOT EXISTS Users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(40) NOT NULL,
            lastname VARCHAR(40) NOT NULL
        )"
    );
    
    $conn->exec("CREATE TABLE IF NOT EXISTS Validation (
            user_id INT AUTO_INCREMENT,
            username VARCHAR(1000) NOT NULL,
            password VARCHAR(1000) NOT NULL,
            PRIMARY KEY (user_id),
            FOREIGN KEY (user_id) REFERENCES Users(user_id)
        )"
    );

    $conn->exec("CREATE TABLE IF NOT EXISTS History (
            user_id INT AUTO_INCREMENT,
            username VARCHAR(1000) NOT NULL,
            endDate DATETIME,
            result ENUM('Win', 'Gameover', 'Cancelled'),
            lives_lost INT(6) UNSIGNED,
            PRIMARY KEY (user_id),
            FOREIGN KEY (user_id) REFERENCES Users(user_id)
        )"
    );
    // echo "Table created successfully<br>";

    // $conn->exec("DELETE FROM Users");
    // $conn->exec("ALTER TABLE Users AUTO_INCREMENT = 1");
    // $conn->exec("DELETE FROM Validation");
    // $conn->exec("DELETE FROM History");
    
    $stm = $conn->prepare("SELECT * FROM Validation WHERE username = :username");
    $stm->bindParam(':username', $UserName);
    $stm->execute();

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        echo "Username already taken. Please choose another one.";
        echo '<br><a href="../Index.php">Try Again!</a>';
    } else {
        $stm = $conn->prepare("INSERT INTO Users(firstname, lastname) VALUES(:firstname, :lastname)");
        $stm->bindParam(':firstname', $fName);
        $stm->bindParam(':lastname', $lName);
        $stm->execute();

        $stm = $conn->prepare("INSERT INTO Validation(username, password) VALUES(:username, :password)");
        $stm->bindParam(':username', $UserName);
        $stm->bindParam(':password', $Password);
        $stm->execute();
        
        $stm = $conn->prepare("INSERT INTO History (username) VALUES(:username)");
        $stm->bindParam(':username', $UserName);
        $stm->execute();

        echo "Signed up successfully!";
        echo '<br><a href="../LogIn/LogIn.html">Home</a>';
    } 
   
    //  Display all users
    //  $stmt = $conn->query("SELECT * FROM Validation");
    //  $allRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //  echo "<br><br>All Users:<br>";
    //  echo "<table border='1'>";
    //  echo "<tr><th>ID</th><th>Username</th><th>Password</th></tr>";
    //  foreach ($allRows as $row) {
    //      echo "<tr><td>".$row['user_id']."</td><td>".$row['username']."</td><td>".$row['password']."</td></tr>";
    //  }
    //  echo "</table>";
} 
catch(PDOException $e) {
    echo "<br>" . $e->getMessage();
}
  $conn = null;
?>
  
