<!doctype html>
<html>
<head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Registracija</title>
    <link rel="stylesheet" type="text/css" href = "./css/login.css">
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
        <h1 align ="center">Registracija</h1>
        <form  action = "register_check.php" method="post" align="center">
            <table align ="center">
            <tr> 
                <td>
                    <div class="inputi">
                            <input type="input" class="inputi_field" placeholder="Ime" name = "Ime" id='name' required />
                     <label for="name" class="inputi_label">Ime</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                            <input type="input" class="inputi_field" placeholder="Email" name="Email" id='name' required />
                     <label for="name" class="inputi_label">Email</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                            <input type="password" class="inputi_field" placeholder="Password" name="Password" id='name' required />
                     <label for="name" class="inputi_label">Geslo</label>
                    </div>
                </td>
            </tr>
            <tr>
               
                <td>
                <br><input type = "submit" value = "Pošlji!">
                </td>
            <tr>
            </table>
        </form>
        <br>
        <a  href = "login.php" >Ste že registrirani ? Kliknite tukaj </a >
        <br>
        <br>
        <br>
        <a  href = "index.php" >Home </a >
        </div>
</body>
</html>