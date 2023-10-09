<?php
session_start();
require_once 'baza.php';
require_once 'cookie.php';

if (isset($_POST['email'], $_POST['password'])) {
    $Email = $_POST['email'];
    $Pass = $_POST['password'];

    if (!empty($Email) && !empty($Pass)) {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $Email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1 && password_verify($Pass, $row['password'])) {
                $_SESSION['email'] = $row['email']; // Assuming 'email' is the correct column name
                $_SESSION['id'] = $row['id'];
                $_SESSION['ime'] = $row['ime'];

                // Redirect to the appropriate page after successful login
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Napačni podatki!');</script>";
                header("refresh:0;url=login.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Niste vpisali vseh podatkov!');</script>";
        header("refresh:0;url=login.php");
    }
} else {
    echo "<script>alert('Niste vpisali vseh podatkov!');</script>";
    header("refresh:0;url=login.php");
    exit();
}
?>
