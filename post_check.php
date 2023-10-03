<?php
require_once 'baza.php';

if (isset($_POST['naslov'], $_POST['content'])) {
    $nas = $_POST['naslov'];
    $con = $_POST['content'];
    echo $nas . "  " . $con;
    echo '<br>';

    if (!empty($nas) && !empty($con)) {
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
                $insertQuery = "INSERT INTO posts (naslov, content) VALUES (:nas, :con)";
                $insertStatement = $pdo->prepare($insertQuery);
                $insertStatement->bindParam(':nas', $nas);
                $insertStatement->bindParam(':con', $con);

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
    echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
    header("refresh:0;url=create_post.php");
}
?>
