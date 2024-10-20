<?php

session_start();

if (!isset($_SESSION['Logged In']) || $_SESSION['Logged In'] !== true) {
    echo '<script type="text/javascript">';
    echo 'alert("You need logging before checking history");';
    echo 'window.location.href="Login/Login.html";';
    echo '</script>';
    exit;
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjectPHP";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT u.user_id, u.firstname, u.lastname, v.username,  MAX(h.endDate) as lastGameDate, h.result, h.lives_lost
            FROM Users u
            JOIN Validation v ON u.user_id = v.user_id
            LEFT JOIN History h ON u.user_id = h.user_id
            GROUP BY u.user_id
            ORDER BY u.user_id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game History</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    h2 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    a {
        display: inline-block;
        padding: 8px 15px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    a:hover {
        background-color: #45a049;
    }
    </style>
</head>


<body>

    <h2>Game History</h2>
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Last Game Date</th>
            <th>Last Game Result</th>
            <th>Lives Lost</th>
        </tr>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
            <td><?php echo htmlspecialchars($row['firstname']); ?></td>
            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['lastGameDate']); ?></td>
            <td><?php echo htmlspecialchars($row['result']); ?></td>
            <td><?php echo htmlspecialchars($row['lives_lost']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="Index.php">Home</a>

</body>

</html>