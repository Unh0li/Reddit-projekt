<?php
session_start();
require_once 'baza.php';
// Check if the user is logged in
if (isset($_SESSION['id'])) {
    // Check if post_id is provided in the query string
    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];

        // Delete the post and associated images (if needed)
        $deleteQuery = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
        $deleteStatement = $pdo->prepare($deleteQuery);
        $deleteStatement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $deleteStatement->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $deleteStatement->execute();
            echo "Post deleted successfully.";
            header("refresh:0;url=subreddit.php?id=".$_SESSION['subreddit']);
        } else {
            echo "Error deleting the post.";
            header("refresh:0;url=subreddit.php?id=".$_SESSION['subreddit']);
        }
    } else {
        echo "You must be logged in to delete a post.";
        header("refresh:0;url=subreddit.php?id=".$_SESSION['subreddit']);
    }
?>
