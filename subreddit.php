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

// Handle likes and dislikes here (to be implemented)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process likes and dislikes here based on post data
    // You will need to implement the logic for handling likes and dislikes
}

// Retrieve the board's name based on subreddit_id
$subreddit_id = $_GET['id'];
$sql_board = "SELECT ime FROM subreddits WHERE id = :id";

// Check if the column 'name' exists in your 'subreddits' table
// Ensure the column name is spelled correctly
// If it's 'subreddit_name' or something different, update the query accordingly
$boardStatement = $pdo->prepare($sql_board);
$boardStatement->bindParam(':id', $subreddit_id);
$boardStatement->execute();
$boardName = $boardStatement->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subreddit</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
    <style>
        /* Add CSS for positioning the "Home" button */
        .meni {
            display: flex;
            justify-content: space-between; /* Place items at each end of the container */
        }
    </style>
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
            <span>Prijavljeni kot: <?php echo $username; ?></span>
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
<div class="board-name">
    <h1><?php echo $boardName; ?></h1>
</div>
<?php
$sql = "SELECT * FROM posts WHERE subreddit_id = :id ORDER BY datum DESC;";
$checkStatement = $pdo->prepare($sql);
$checkStatement->bindParam(':id', $subreddit_id);
$checkStatement->execute();
while ($row = $checkStatement->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='welcome'>";
    echo "<h2>";
    echo $row['naslov'];
    echo "</h2>";
    echo "<br>";
    echo "<p>";
    echo $row['content'];
    echo "</p>";
    echo "<form method='POST' action='votes.php'>";
    echo "<button type='submit' name='like'>Like</button>";
    echo "  ";
    echo "<button type='submit' name='dislike'>Dislike</button>";
    echo "</form>";
    echo "</div>";
}
?>
</body>
</html>
