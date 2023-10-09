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

// Provide a default value for subreddit_id if it's not set in $_GET
$subreddit_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Function to increment votes in the database
// Retrieve the board's name based on subreddit_id
if ($subreddit_id > 0) {
    $sql_board = "SELECT ime FROM subreddits WHERE id = :id";

    // Check if the column 'name' exists in your 'subreddits' table
    // Ensure the column name is spelled correctly
    // If it's 'subreddit_name' or something different, update the query accordingly
    $boardStatement = $pdo->prepare($sql_board);
    $boardStatement->bindParam(':id', $subreddit_id);
    $boardStatement->execute();
    $boardName = $boardStatement->fetchColumn();
} else {
    $boardName = "Subreddit Not Found"; // Provide a default value
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="js/menu.js" defer></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subreddit</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
</head>
<body>
<header>
    <div class="meni">
    <div class="slika">
            <div class="img-container">
                <img src="./slike/ers.png" class="slike" alt="Image">
                <div class="post">
                    <p>Postme</p>
                </div>
            </div>
        </div>
        
        <div class="profil">
            <span>Prijavljeni ste kot: <?php echo $username; ?></span>
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
    if(isset($_SESSION['id']) && $row['user_id'] == $_SESSION['id']){
        echo "<button style = 'float: right;' onclick=\"location.href='delete_post.php?id=".$row['id']."'\">Delete</button><br><br>";
        echo "<button style = 'float: right;' onclick=\"location.href='edit.php?id=".$row['id']."'\">Edit</button>";
    }
    $sql = "SELECT * FROM users WHERE id = :id;";
    $checkStatement2 = $pdo->prepare($sql);
    $checkStatement2->bindParam(':id', $row['user_id']);
    $checkStatement2->execute();
    $row2 = $checkStatement2->fetch(PDO::FETCH_ASSOC);
    echo "<p>Posted by: <a href = user.php?id=".$row['user_id'].">".$row2['ime']."</a></p>";
    echo "<h2>";
    echo $row['naslov'];
    echo "</h2>";
    echo "<br>";
    echo "<p>";
    echo $row['content'];
    echo "</p>";
    $sql2 = "SELECT * FROM slike WHERE post_id = :id;";
    $checkStatement2 = $pdo->prepare($sql2);
    $checkStatement2->bindParam(':id', $row['id']);
    $checkStatement2->execute();
    while($row2 = $checkStatement2->fetch(PDO::FETCH_ASSOC)){
        echo "<img src='".$row2['url']."' alt='Post Image' class = 'slike'>";
        echo "<br>";
    }
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
