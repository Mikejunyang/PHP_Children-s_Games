<?php
ini_set('session.gc_maxlifetime', 900);
session_set_cookie_params(900);

session_start();

if (!isset($_SESSION['Logged In']) || $_SESSION['Logged In'] !== true) {
    echo '<script type="text/javascript">';
    echo 'alert("You need logging before checking history");';
    echo 'window.location.href="Login/Login.html";';
    echo '</script>';
    exit;
}
?>
<script>
var timeout = null;

function resetTimeout() {
    clearTimeout(timeout);
    startTimeout();
}

function startTimeout() {
    timeout = setTimeout(function() {
        window.location.href = "LogOut/logout.php";
    }, 90000);
}

startTimeout();

document.addEventListener("mousemove", resetTimeout);
document.addEventListener("keypress", resetTimeout);
</script>

<?php
function saveDB($result, $lives){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ProjectPHP"; 
    $user = $_SESSION['UserName'];
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $date = date('Y-m-d H:i:s');

        $stm = $conn->prepare("UPDATE History SET endDate = :endDate, result = :result, lives_lost = :lives_lost WHERE username = :username");
        $stm->bindParam(':endDate', $date);
        $stm->bindParam(':result', $result);
        $stm->bindParam(':lives_lost', $lives);
        $stm->bindParam(':username', $user);
        $stm->execute();
    }    
    catch(PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
      $conn = null;
}

// Helper function to generate random sequences of numbers or letters
function generateRandomSequence($type = 'number', $length = 6)
{
    $sequence = [];
    if ($type === 'number') {
        for ($i = 0; $i < $length; $i++) {
            $sequence[] = rand(0, 9);
        }
    } else { // 'letter'
        $letters = range('A', 'Z');
        shuffle($letters);
        $sequence = array_slice($letters, 0, $length);
    }
    return $sequence;
}

// Restart game if requested
if (isset($_POST['restart'])) {
    session_destroy();
    session_start();
}

// Initialize or reset game state
if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 1;
    $_SESSION['lives'] = 6;
    $_SESSION['gameStatus'] = 'active';
    $_SESSION['sequence'] = generateRandomSequence($_SESSION['level'] === 5 || $_SESSION['level'] < 3 ? 'letter' : 'number');
}

// Function to simulate database recording (placeholder)
function recordOutcome($status){
    echo "<p><br>Outcome recorded as: $status</p>";
}

$cancelMessage = '';
// Check for game cancellation
if (isset($_POST['cancel'])) {
    $_SESSION['gameStatus'] = 'Cancelled';
    recordOutcome('Incomplete');
    $cancelMessage = "<p><br>Game marked as incomplete. Please restart the game.</p>";
    $save = saveDB($_SESSION['gameStatus'] ,(6 - $_SESSION['lives']));
}

// Verify user input and adjust game state
if (isset($_POST['submitAnswer'])) {
    $userInputRaw = array_map('trim', explode(',', $_POST['userInput']));
    $correctAnswer = false;

    // Convert user input to the appropriate type for numeric levels
    if ($_SESSION['level'] >= 3 && $_SESSION['level'] != 5) {
        $userInput = array_map('intval', $userInputRaw);
    } else {
        $userInput = $userInputRaw;
    }

    $sequenceForComparison = $_SESSION['sequence'];

    // Sort or reverse sort the sequence for comparison
    if ($_SESSION['level'] == 1 || $_SESSION['level'] == 5) {
        sort($sequenceForComparison);
    } elseif ($_SESSION['level'] == 2 || $_SESSION['level'] == 4) {
        rsort($sequenceForComparison);
    } elseif ($_SESSION['level'] == 3 || $_SESSION['level'] == 6) {
        sort($sequenceForComparison, SORT_NUMERIC);
    }

    // Determine if the answer is correct
    if ($_SESSION['level'] <= 4) {
        $correctAnswer = $userInput === $sequenceForComparison;
    } else {
        $correctAnswer = [$userInput[0], end($userInput)] === [$sequenceForComparison[0], end($sequenceForComparison)];
    }

    if ($correctAnswer) {
        if ($_SESSION['level'] == 6) {
            $_SESSION['gameStatus'] = 'Win';
            recordOutcome('Win');
            echo "<p><br>Congratulations, you've won the game!</p>";
            $save = saveDB($_SESSION['gameStatus'], (6- $_SESSION['lives']));
        } else {
            $_SESSION['level']++;
            $_SESSION['sequence'] = generateRandomSequence($_SESSION['level'] === 5 || $_SESSION['level'] < 3 ? 'letter' : 'number');
            echo "<p><br>Correct answer! Proceeding to level {$_SESSION['level']}.</p>";
        }
    } else {
        if ($_SESSION['lives']!= 0){
            $_SESSION['lives']--;
            if ($_SESSION['lives'] == 0) {
                $_SESSION['gameStatus'] = 'Gameover';
                recordOutcome('Game Over');
                echo "<p><br>Game Over. You've exhausted all lives.</p>";
                $save = saveDB($_SESSION['gameStatus'], (6- $_SESSION['lives']));
            } else {
                echo "<p><br>Incorrect answer. You have {$_SESSION['lives']} lives left.</p>";
                echo "<p><br>Try again! You can do it!</p>";
            }
        }        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include 'template/head.php'; ?>
    <title>Simple Game</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <?php include 'template/header.php'; ?>
    <div class="container mt-5 pt-5">
        <?php if (!empty($cancelMessage))
            echo $cancelMessage; ?>

        <?php if ($_SESSION['gameStatus'] === 'active'): ?>
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title">Level:
                    <?php echo $_SESSION['level'];?>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">Lives:
                    <?php echo $_SESSION['lives']; ?>
                </h6>
                <p class="card-text">Sequence:
                    <?php echo implode(', ', $_SESSION['sequence']); ?>
                </p>
                <p class="card-text game-instruction"></p> <!-- JavaScript 将填充这里 -->
                <form method="post">
                    <div class="form-group">
                        <label for="userInput">Your Answer (comma separated):</label>
                        <input type="text" class="form-control" id="userInput" name="userInput"
                            placeholder="Enter your answer here">
                    </div>
                    <button type="submit" name="submitAnswer" class="btn btn-primary">Submit Answer</button>
                    <button type="submit" name="cancel" class="btn btn-warning">Cancel Game</button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <h2>Game Status:
            <?php echo $_SESSION['gameStatus']; ?>
        </h2>
        <form method="post">
            <button type="submit" name="restart" class="btn btn-success">Restart Game</button>
        </form>
        <?php endif; ?>
    </div>

    <!-- <footer>
        <?php //include 'template/footer.php'; ?>
    </footer> -->

    <script>
    $(document).ready(function() {
        var level = <?php echo json_encode($_SESSION['level']); ?>;
        var instruction = "";
        switch (level) {
            case 1:
                instruction = "Order the letters in ascending order (A to Z).";
                break;
            case 2:
                instruction = "Order the letters in descending order (Z to A).";
                break;
            case 3:
                instruction = "Order the numbers in ascending order (smallest to largest).";
                break;
            case 4:
                instruction = "Order the numbers in descending order (largest to smallest).";
                break;
            case 5:
                instruction = "Identify the first (smallest) and last (largest) letter in the sequence.";
                break;
            case 6:
                instruction = "Identify the smallest and the largest number in the sequence.";
                break;
        }
        $(".game-instruction").text(instruction);
    });
    </script>
    <script>
    // 示例：使用 jQuery 显示动态提示消息
    $(".game-instruction");
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
