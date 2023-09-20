<?php
require_once 'baza.php';
require_once 'cookie.php';

if (isset($_POST['email'], $_POST['password'])) {
    $Email = $_POST['email'];
    $Pass = $_POST['password'];

    if (!empty($Email) && !empty($Pass)) {
        $kp = sha1($Pass);

        $query = "SELECT * FROM users WHERE email = '$Email' AND password = '$kp'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            session_start();
            $_SESSION['email'] = $Email;
            $_SESSION['id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Napačni podatki!');</script>";
            header("refresh:0;url=index.php");
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
