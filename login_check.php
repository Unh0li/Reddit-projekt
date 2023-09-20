<?php
require_once 'baza.php';
require_once 'cookie.php';

if (isset($_POST['email'], $_POST['password'])) {
    $Email = $_POST['email'];
    $Pass = $_POST['password'];

    if (!empty($Email) && !empty($Pass)) {
        $kp = sha1($Pass);

        try {
            $query = "SELECT * FROM users WHERE email = :email AND password = :password";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $Email);
            $stmt->bindParam(':password', $kp);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {
                session_start();
                $_SESSION['email'] = $Email;
                $_SESSION['id'] = $row['id'];
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Napačni podatki!');</script>";
                header("refresh:0;url=index.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Niste vpisali vseh podatkov!');</script>";
        header("refresh:0;url=index.php");
    }
} else {
    echo "<script>alert('Niste vpisali vseh podatkov!');</script>";
    header("refresh:0;url=index.php");
    exit();
}
?>
