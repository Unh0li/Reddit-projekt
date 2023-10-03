<!doctype html>
<html>
<head>
    <meta charset = "utf-8">
    <title>Ustvari post</title>
    <link rel="stylesheet" type="text/css" href = "./css/register_style.css">
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
        <h1 align ="center">Ustvari svoj post!</h1>
        <form  action = "post_check.php" method="post" align="center">
            <table align ="center">
            <tr> 
                <td>
                    <div class="inputi">
                            <input type="input" class="inputi_field" placeholder="naslov" name = "naslov" id='name' required />
                     <label for="name" class="inputi_label">Naslov posta</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                            <input type="textbox" class="inputi_field" placeholder="content" name="content" id='name' required />
                     <label for="name" class="inputi_label">Content</label>
                    </div>
                </td>
            </tr>
            <tr>
               
                <td>
                <br><input type = "submit" value = "Ustvari!">
                </td>
            <tr>
            </table>
        </form>
        <br>
        <a  href = "index.php" >Home </a >
        </div>
</body>
</html>