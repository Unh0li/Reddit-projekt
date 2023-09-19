<?php
$host="localhost";
$user="root";
$password="";
$link=mysqli_connect($host,$user,$password) or die ("Povezava ni uspela");
$db="reddit_base";
mysqli_select_db($link, $db) or die ("Povezava ni uspela");
mysqli_set_charset($link,"utf8");
?>