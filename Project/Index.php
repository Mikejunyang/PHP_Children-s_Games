<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'template/head.php'; ?>
    <style>
    body {
        background-image: url('image/1.jpg');
        background-size: cover;
        /* 覆盖整个页面 */
        background-position: center;
        /* 中心对齐背景图片 */
        background-repeat: no-repeat;
        /* 不重复背景图片 */
        background-attachment: fixed;
        /* 背景图片固定，不随滚动条滚动 */
    }
    </style>

</head>

<body>
    <header>
        <?php include 'template/header.php'; ?>
    </header>

    <main class="container mt-5">
        <br>
        <br>
        <h2 class="text-center mb-4" style="color:black">Welcome to the Children's Game Portal</h2>
        <div class="row justify-content-center">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="image/2.jpg" class="card-img-top" alt="Game Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Game</h5>
                        <p class="card-text">Experience an adventurous journey in Game 1. Solve puzzles and overcome
                            challenges.</p>
                        <a href="Game.php" class="btn btn-primary mt-auto hidden-link">Play Now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- <audio id="myAudio" controls autoplay>
            <source src="audio/audio1.wav" type="audio/wav">
        </audio> -->

    </main>
    <!-- <?php //include 'template/footer.php'; ?> -->
</body>

</html>