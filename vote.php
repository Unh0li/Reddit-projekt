<?php
session_start();
require_once 'baza.php';

if (isset($_GET['vote'], $_GET['id'])) {
    $post_id = $_GET['id'];
    $vote = $_GET['vote'];
    $subreddit = $_SESSION['subreddit'];

    // Check if the user is logged in and user_id is set in the session
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];

        try {
            // Check if a vote already exists for the user and post
            $checkQuery = "SELECT * FROM post_votes WHERE user_id = :user AND post_id = :post";
            $checkStatement = $pdo->prepare($checkQuery);
            $checkStatement->bindParam(':user', $user_id, PDO::PARAM_INT);
            $checkStatement->bindParam(':post', $post_id, PDO::PARAM_INT);
            $checkStatement->execute();

            if ($checkStatement->rowCount() > 0) {
                $existingVote = $checkStatement->fetch(PDO::FETCH_ASSOC);
                if ($existingVote['vote'] == $vote) {
                    // If the user is trying to vote the same way, delete the vote
                    $deleteQuery = "DELETE FROM post_votes WHERE user_id = :user AND post_id = :post";
                    $deleteStatement = $pdo->prepare($deleteQuery);
                    $deleteStatement->bindParam(':user', $user_id, PDO::PARAM_INT);
                    $deleteStatement->bindParam(':post', $post_id, PDO::PARAM_INT);
                    $deleteStatement->execute();
                    echo "<script>alert('Vote deleted successfully');</script>";
                } else {
                    // If the user is trying to change their vote, update its value
                    $updateQuery = "UPDATE post_votes SET vote = :vote WHERE user_id = :user AND post_id = :post";
                    $updateStatement = $pdo->prepare($updateQuery);
                    $updateStatement->bindParam(':user', $user_id, PDO::PARAM_INT);
                    $updateStatement->bindParam(':post', $post_id, PDO::PARAM_INT);
                    $updateStatement->bindParam(':vote', $vote, PDO::PARAM_INT);
                    $updateStatement->execute();
                }
            } else {
                // If no vote exists, insert a new vote
                $insertQuery = "INSERT INTO post_votes (user_id, post_id, vote) VALUES (:user, :post, :vote)";
                $insertStatement = $pdo->prepare($insertQuery);
                $insertStatement->bindParam(':user', $user_id, PDO::PARAM_INT);
                $insertStatement->bindParam(':post', $post_id, PDO::PARAM_INT);
                $insertStatement->bindParam(':vote', $vote, PDO::PARAM_INT);
                $insertStatement->execute();
            }
            header("refresh:0;url=subreddit.php?id=".$_SESSION['subreddit']);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('You are not logged in!');</script>";
        header("refresh:0;url=login.php");
    }
} else {
    echo "<script>alert('Incomplete data!');</script>";
    header("refresh:0;url=subreddit.php?id=".$_SESSION['subreddit']);
}
?>
