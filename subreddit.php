<?php
require_once "cookie.php";
include_once 'baza.php';

// Check if username is set in session
if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];
    $showLogoutButton = true; // Set a flag to show the logout button
    $showCreateSubredditButton = true; // Set a flag to show the Create Subreddit button
} else {
    $username = "Gost";
    $showLogoutButton = false; // Set a flag to hide the logout button
    $showCreateSubredditButton = false; // Set a flag to hide the Create Subreddit button
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
        <img src="./slike/ers.png">
        <p>Postme</p>
        <div class="profil">
            <span>Prijavljeni kot: <?php echo $username; ?></span>
            <?php if ($showLogoutButton) { ?>
                <a href="logout.php">
                    <button>Logout</button>
                </a>
            <?php } ?>
            <?php if ($showCreateSubredditButton) { ?>
                <a href="subreddit_create.php">
                    <button>Create Subreddit</button>
                </a>
            <?php } ?>
        </div>
    </div>
</header>
<?php
    $subreddit_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE subreddit_id = :id ORDER BY datum DESC;";
    $checkStatement = $pdo->prepare($sql);
    $checkStatement->bindParam(':id', $subreddit_id);
    $checkStatement->execute();
    while ($row = $checkStatement->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='welcome'>";
        echo "<h1>";
        echo $row['naslov'];
        echo "</h1>";
        echo "<br>";
        echo "<p>";
        echo $row['content'];
        echo "</p>";
        echo "</div>";
    }
?>
<div class="welcome">
</div>
</body>
</html>
