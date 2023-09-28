<?php
require_once "cookie.php";
include_once 'baza.php';

if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];
    $showLogoutButton = true;
    $showCreateSubredditButton = true; 
} else {
    $username = "Gost";
    $showLogoutButton = false; 
    $showCreateSubredditButton = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seos</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
</head>
<body>
<header>
    <div class="meni">
        <div>
            <img src="./slike/ers.png">
            <p>Postme</p>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <button onclick="searchFunction()">Search</button>
        </div>
        <div class="profil">
            <span class="ime">Prijavljeni ste kot: <?php echo $username; ?></span>
            <!-- "Home" button on the right side next to the logout button -->
            <button onclick="location.href='index.php'">Home</button>
            <?php if ($showLogoutButton) { ?>
                <button onclick="location.href='logout.php'">Logout</button>
            <?php } ?>
            <?php if ($showCreateSubredditButton) { ?>
                <button onclick="location.href='subreddit_create.php'">Create board</button>
            <?php } ?>
        </div>
    </div>
</header>
<div class="welcome">
    <h1>Welcome to Postme.</h1>
    <p>Totally not a school project website</p>
    <a href="register.php">
        <button>Postani del Postme!</button>
    </a>
    <br>
    <br>
    <a href="login.php">
        <button>Login</button>
    </a>
    <br>
    <br>
    </div>
    <div class="welcome">
    <h1>Boardi : </h1>
    <?php
    $sql = "SELECT * FROM subreddits;";
    $checkStatement = $pdo->prepare($sql);
    $checkStatement->execute();
    while ($row = $checkStatement->fetch(PDO::FETCH_ASSOC)) {
        echo "<br><p><button onclick=\"location.href='subreddit.php?id=".$row['id']."'\"'>
            ".$row['ime']."</button>
             - ".$row['opis']."</p> <br>";
    }
?>
</div>
</body>
</html>
