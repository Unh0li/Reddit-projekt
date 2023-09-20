<?php
require_once "cookie.php";
include_once 'baza.php';
if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];
} else {
    $username = "Gost";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seos</title>
    <link rel="stylesheet" type="text/css" href = "css/index_style.css">
</head>
<body>
    <header>
    <div class="meni">
        <img src="./slike/ers.png">
        <p>Postme</p>
    </div>
    </header>
    <div class="welcome">
        <h1> Welcome to Postme.</h1>
        <p>Totally not a school project website</p>
        <a href="register.php">
        <button>Postani del Postme!</button>
        </a>
        <br>
        <span>Prijavljeni kot: <?php echo $username; ?></span>
    </div>
    <br>
</body>
</html>