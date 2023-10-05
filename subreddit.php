<?php
require_once "cookie.php";
include_once 'baza.php';

// Check if username is set in session
if (isset($_SESSION['ime'])) {
    $username = $_SESSION['ime'];
    $showLogoutButton = true;
    $showCreateSubredditButton = true; 
} else {
    $username = "Gost";
    $showLogoutButton = false; 
    $showCreateSubredditButton = false;
}

// Function to increment votes in the database
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
</head>
<body>
<header>
    <div class="meni">
        <div>
            <img src="./slike/ers.png">
            <p>Postme</p>
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
                <button onclick="location.href='create_post.php?id=<?php echo $subreddit_id; ?>'">Create Post</button>
            <?php } ?>
        </div>
    </div>
</header>
<div class="board-name">
    <h1><?php echo $boardName; ?></h1>
</div>
<?php
$_SESSION['subreddit'] = $subreddit_id;
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
    echo "<br>";

    $sql2 = "SELECT COUNT(*) FROM post_votes WHERE post_id = :id AND vote = 1";
    $checkStatement2 = $pdo->prepare($sql2);
    $checkStatement2->bindParam(':id', $row['id']);
    $checkStatement2->execute();

    // Fetch the count and save it in a variable
    $likeCount = $checkStatement2->fetchColumn();

    $sql3 = "SELECT COUNT(*) FROM post_votes WHERE post_id = :id AND vote = 0";
    $checkStatement3 = $pdo->prepare($sql3);
    $checkStatement3->bindParam(':id', $row['id']);
    $checkStatement3->execute();

    // Fetch the count and save it in a variable
    $dislikeCount = $checkStatement3->fetchColumn();

    $karma = $likeCount - $dislikeCount;


    echo "<p>Karma: ".$karma." </p>";
    
    // Like button div
echo "<div class='like'>";
echo "<button type='submit' onclick=\"location.href='vote.php?vote=1&id=".$row['id']."'\" name='like'>Like</button>";
echo "</div>";

// Dislike button div
echo "<div class='dislike'>";
echo "<button type='submit' onclick=\"location.href='vote.php?vote=0&id=".$row['id']."'\" name='dislike'>Dislike</button>";
echo "</div>";

    
    echo "</div>";
}
?>
</body>
</html>
