<?php
require_once 'baza.php';

if (isset($_POST['Ime'], $_POST['Email'], $_POST['Password'])) {
    $Ime = $_POST['Ime'];
    $Email = $_POST['Email'];
    $Pass = $_POST['Password'];

    echo $Ime . "  " . $Email . "  " . $Pass;
    echo '<br>';

    if (!empty($Ime) && !empty($Email) && !empty($Pass)) {
        // Preveri, ali geslo izpolnjuje zahteve
        $pattern = '/^(?=.*[A-Z]).+$/';
        if (preg_match($pattern, $Pass)) {
            $kp = sha1($Pass);

            $checkQuery = "SELECT * FROM users WHERE email = '$Email'";
            $checkResult = mysqli_query($link, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script>alert('Uporabnik je že registriran');</script>";
                header("refresh:0;url=register.php");
            } else {
                $insertQuery = "INSERT INTO users (ime, email, password) VALUES ('$Ime', '$Email', '$kp')";

                if (mysqli_query($link, $insertQuery)) {
                    header("refresh:0;url=login.php");
                } else {
                    echo "<script>alert('Registracija neuspešna!');</script>";
                }
            }
        } else {
            echo "<script>alert('Geslo mora vsebovati vsaj eno veliko črko.');</script>";
            header("refresh:0;url=register.php");
        }
    } else {
        echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
        header("refresh:0;url=register.php");
    }
} else {
    echo "<script>alert('Niste vnesli vseh podatkov!');</script>";
    header("refresh:0;url=register.php");
}
?>

