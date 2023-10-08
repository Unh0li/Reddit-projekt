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
                    // Check if files were uploaded
                    if (!empty($_FILES['slika']['name'][0])) {
                        $imagePaths = [];
                        
                        // Insert post information into the database
                        $insertQuery = "INSERT INTO posts (naslov, content, subreddit_id, user_id) VALUES (:nas, :con, :subreddit_id, :user_id)";
                        $insertStatement = $pdo->prepare($insertQuery);
                        $insertStatement->bindParam(':nas', $nas);
                        $insertStatement->bindParam(':con', $con);
                        $insertStatement->bindParam(':subreddit_id', $subreddit_id, PDO::PARAM_INT);
                        $insertStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                        if ($insertStatement->execute()) {
                            $post_id = $pdo->lastInsertId(); // Get the last inserted post_id
                            
                            // Loop through each uploaded file
                            foreach ($_FILES['slika']['tmp_name'] as $index => $tmpName) {
                                $imageName = $_FILES['slika']['name'][$index];
                                $imagePath = "slike/" . $imageName;

                                // Move the uploaded file to the "/img" directory
                                if (move_uploaded_file($tmpName, $imagePath)) {
                                    $imagePaths[] = $imagePath;

                                    // Insert image information into the database
                                    $insertImageQuery = "INSERT INTO slike (post_id, url) VALUES (:post_id, :image_url)";
                                    $insertImageStatement = $pdo->prepare($insertImageQuery);
                                    $insertImageStatement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                                    $insertImageStatement->bindParam(':image_url', $imagePath);
                                    $insertImageStatement->execute();
                                }
                            }
                            header("refresh:0;url=index.php");
                        } else {
                            echo "<script>alert('Vnos neuspešen!');</script>";
                        }
                    } else {
                        echo "<script>alert('Niste naložili nobene slike!');</script>";
                        header("refresh:0;url=create_post.php");
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
