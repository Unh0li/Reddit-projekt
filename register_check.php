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
            // Hash the password using password_hash()
            $hashedPassword = password_hash($Pass, PASSWORD_DEFAULT);

            try {
                // Check if the email is already registered
                $checkQuery = "SELECT * FROM users WHERE email = :email";
                $checkStmt = $pdo->prepare($checkQuery);
                $checkStmt->bindParam(':email', $Email);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    echo "<script>alert('Uporabnik je že registriran');</script>";
                    header("refresh:0;url=register.php");
                } else {
                    // Insert new user into the database
                    $insertQuery = "INSERT INTO users (ime, email, password) VALUES (:ime, :email, :password)";
                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->bindParam(':ime', $Ime);
                    $insertStmt->bindParam(':email', $Email);
                    $insertStmt->bindParam(':password', $hashedPassword);
                    $insertStmt->execute();

                    header("refresh:0;url=login.php");
                }
            } catch (PDOException $e) {
                echo "<script>alert('Registracija neuspešna!');</script>";
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
