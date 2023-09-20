<?php
// Start the session
session_start();

// Include the database connection file
require_once 'baza.php';

// Check if the user is logged in and has a user ID in the session
if (isset($_POST['ime'], $_POST['opis']) && isset($_SESSION['id'])) {
    $ime = $_POST['ime'];
    $opis = $_POST['opis'];
    $user_id = $_SESSION['id']; // Get the user ID from the session

    echo $ime . "  " . $opis;
    echo '<br>';

    if (!empty($ime) && !empty($opis)) {
        try {
            // Check if the subreddit with the same name already exists
            $checkQuery = "SELECT * FROM subreddits WHERE ime = :ime";
            $checkStatement = $pdo->prepare($checkQuery);
            $checkStatement->bindParam(':ime', $ime);
            $checkStatement->execute();

            if ($checkStatement->rowCount() > 0) {
                echo "<script>alert('Board s tem imenom že obstaja');</script>";
                header("refresh:0;url=subreddit_create.php");
            } else {
                // Insert the new subreddit
                $insertQuery = "INSERT INTO subreddits (ime, opis, moderator_id) VALUES (:ime, :opis, :user_id)";
                $insertStatement = $pdo->prepare($insertQuery);
                $insertStatement->bindParam(':ime', $ime);
                $insertStatement->bindParam(':opis', $opis);
                $insertStatement->bindParam(':user_id', $user_id);

                if ($insertStatement->execute()) {
                    header("refresh:0;url=index.php");
                } else {
                    echo "<script>alert('Vnos boarda neuspešen!');</script>";
                }
            }
        } catch (PDOException $e) {
            echo "<script>alert('Napaka pri povezavi z bazo: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
        header("refresh:0;url=subreddit_create.php");
    }
} else {
    echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
    header("refresh:0;url=subreddit_create.php");
}
?>
