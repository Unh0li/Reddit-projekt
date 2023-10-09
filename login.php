<?php
require_once "baza.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "./css/login.css">
        <title>Prijava</title>
    </head>
    <body>

    <header>
    <div class="meni">
        <img src="./slike/ers.png">
        <p>Postme</p>
    </div>
    </header>
        <div class ="reg">
            <br>
        <h1 align ="center">Login</h1>
        <form action = "login_check.php" method="post" align="center">
            <table align ="center">
                <td><div class="inputi">
                            <input type="email" class="inputi_field" placeholder="email" name = "email" id='name' required />
                     <label for="name" class="inputi_label">Email</label>
                    </div></td>
            </tr>
            <tr>
                <td><div class="inputi">
                        <input type="password" class="inputi_field" placeholder="password" name="password" id='name' required />
                     <label for="name" class="inputi_label">Geslo</label>
                    </div></td>
            </tr>
            <tr>
               
                <td>
                <br><input type = "submit" value = "Pošlji!">
                </td>
            <tr>
            </table>
        </form>
        <br>
        <a  href = "register.php" >Še niste registrirani ? Kliknite tukaj </a >
        <br>
        <br>
        <br>
        <a  href = "index.php" >Home </a >
        <p>Lahko se tudi prijaviš z Google računom: <a href = "<?php echo $google_client->createAuthUrl()?>">Registriraj se z Google računom</a>
        </div>
</body>
</html>