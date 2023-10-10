<?php
require_once 'baza.php'; // Include your database connection details from baza.php

$query = "SELECT * FROM subreddits";
$stmt = $pdo->prepare($query);
$stmt->execute();

$subreddits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Ustvari post</title>
    <link rel="stylesheet" type="text/css" href="./css/postcreate.css">
</head>
<body>
<header>
    <div class="meni">
        <img src="./slike/ers.png">
        <p>Postme</p>
    </div>
</header>
<div class="reg">
    <br>
    <h1 align="center">Ustvari svoj post!</h1>
    <form action="post_check.php" method="post" align="center" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td>
                    <label for="board"> Board:</label>
                    <br>
                    <select name="subreddit_id" id="subreddit_dropdown">
                        <?php
                        foreach ($subreddits as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['ime'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                        <input type="input" class="inputi_field" placeholder="naslov" name="naslov" id='name' required />
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
                    <div class="inputi">
                    <label for="slika">Slike:</label>
                    <br>
                    <input type="file" id="slika" name="slika[]" required multiple><br><br>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <br><input type="submit" value="Ustvari!">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <a href="index.php">Home</a>
</div>
</body>
</html>
