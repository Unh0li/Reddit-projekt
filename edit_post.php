<?php
session_start();
require_once 'baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in and user_id is set in the session
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $post_id = $_POST['post_id'];
        $subreddit_id = $_POST['subreddit_id'];
        $naslov = $_POST['naslov'];
        $content = $_POST['content'];

        try {
            // Check if the logged-in user is the same as the post's user_id
            $checkOwnershipQuery = "SELECT user_id FROM posts WHERE id = :post_id";
            $checkOwnershipStatement = $pdo->prepare($checkOwnershipQuery);
            $checkOwnershipStatement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $checkOwnershipStatement->execute();
            $postOwner = $checkOwnershipStatement->fetch(PDO::FETCH_ASSOC);

            if ($postOwner['user_id'] == $user_id) {
                // Update the post with the new data
                $updateQuery = "UPDATE posts SET naslov = :naslov, content = :content WHERE id = :post_id";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->bindParam(':naslov', $naslov, PDO::PARAM_STR);
                $updateStatement->bindParam(':content', $content, PDO::PARAM_STR);
                $updateStatement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                $updateStatement->execute();
                header("Location: subreddit.php?id=$subreddit_id");
            } else {
                echo "<script>alert('You do not have permission to edit this post!');</script>";
                header("refresh:0;url=subreddit.php?id=$subreddit_id");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('You are not logged in!');</script>";
        header("refresh:0;url=login.php");
    }
} else {
    // Display the edit post form with existing data
    // You can use the code you provided for the form with some modifications
    // Make sure to populate the fields with the existing post data
}
?>
