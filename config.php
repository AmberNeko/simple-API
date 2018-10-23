<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "danielwu";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->exec("set names utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
?>