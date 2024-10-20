<?php

$loggedIn = isset($_SESSION['Logged In']) && $_SESSION['Logged In'] === true;
$username = $loggedIn ? $_SESSION['UserName'] : '';
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">PHP GAME</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="./Index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./game_history.php">Game History</a>
                    </li>
                    <!-- 将 Sign Up 和 Login 作为下拉菜单项 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php if ($loggedIn): ?>
                                <!-- User is logged in, show username and logout link -->
                                <a class="dropdown-item disabled" href="#"><?php echo htmlspecialchars($username); ?></a>
                                <a class="dropdown-item" href="./LogOut/logout.php">Log Out</a>
                                <a class="dropdown-item" href="./SignUp/SignUp.html">Sign Up</a>
                            <?php else: ?>
                                <!-- User is not logged in, show signup and login links -->
                                <a class="dropdown-item" href="./SignUp/SignUp.html">Sign Up</a>
                                <a class="dropdown-item" href="./LogIn/LogIn.html">Log In</a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
