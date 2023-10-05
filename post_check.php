<?php
session_start();
require_once 'baza.php';

if (isset($_POST['naslov'], $_POST['content'], $_POST['subreddit_id'])) {
    $nas = $_POST['naslov'];
    $con = $_POST['content'];
    $subreddit_id = $_POST['subreddit_id'];

    // Check if the user is logged in and user_id is set in the session
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];

        if (!empty($nas) && !empty($con) && !empty($subreddit_id)) {
            try {
                // Assuming $pdo is your database connection from baza.php
                $checkQuery = "SELECT * FROM posts WHERE naslov = :nas";
                $checkStatement = $pdo->prepare($checkQuery);
                $checkStatement->bindParam(':nas', $nas);
                $checkStatement->execute();

                if ($checkStatement->rowCount() > 0) {
                    echo "<script>alert('Knjiga je že vnešena');</script>";
                    header("refresh:0;url=create_post.php");
                } else {
                    $insertQuery = "INSERT INTO posts (naslov, content, subreddit_id, user_id) VALUES (:nas, :con, :subreddit_id, :user_id)";
                    $insertStatement = $pdo->prepare($insertQuery);
                    $insertStatement->bindParam(':nas', $nas);
                    $insertStatement->bindParam(':con', $con);
                    $insertStatement->bindParam(':subreddit_id', $subreddit_id, PDO::PARAM_INT);
                    $insertStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                    if ($insertStatement->execute()) {
                        header("refresh:0;url=index.php");
                    } else {
                        echo "<script>alert('Vnos neuspešen!');</script>";
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
            header("refresh:0;url=create_post.php");
        }
    } else {
        echo "<script>alert('Niste prijavljeni!');</script>";
        header("refresh:0;url=login.php"); // Redirect to the login page
    }
} else {
    echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
    header("refresh:0;url=create_post.php");
}
?>
