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
    <title>Ustvari post</title>
    <link rel="stylesheet" type="text/css" href="./css/register_style.css">
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
    <h1 align="center">Uredi svoj post!</h1>
    <form action="edit_post.php" method="post" align="center" enctype="multipart/form-data">
        <table align="center">
            <tr>
                <td><p> Board:</p>
                    <input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>" />
                    
                    <select name="subreddit_id" id="subreddit_dropdown" readonly >
                        <?php 
                        $sql = "SELECT * FROM posts WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$_GET['id']]);
                        $post = $stmt->fetch(PDO::FETCH_ASSOC);
                        $subreddit_id = $post['subreddit_id'];
                        $naslov = $post['naslov'];
                        $contents = $post['content'];

                        $sql2 = "SELECT * FROM subreddits WHERE id = ?";
                        $stmt2 = $pdo->prepare($sql2);
                        $stmt2->execute([$subreddit_id]);
                        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $subreddit = $row['ime'];
                        echo "<option value='".$subreddit_id."'> ".$subreddit."</option>";
                        
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                        <input type="input" class="inputi_field" placeholder="naslov" name="naslov" id='name' value = "<?php echo $naslov;?>" required />
                        <label for="name" class="inputi_label">Naslov posta</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="inputi">
                        <input type="textbox" class="inputi_field" placeholder="content" name="content" id='name'  value = "<?php echo $contents;?>" required />
                        <label for="name" class="inputi_label">Content</label>
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
