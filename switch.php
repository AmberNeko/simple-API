<?php
session_start();
if($_SESSION['log'] != 'login'){
    header('Location:NEW.html');
    exit('尚未登入<a href="NEW.html">回首頁</a>');
}
require_once('config.php');

$x = $_POST['id'];

$sqlCol = $_POST['sqlCol'];
$sqlVal = $_POST['sqlVal'];

try {
    $sql = "UPDATE danielwu SET ".$sqlCol." = '".$sqlVal."' WHERE id=".$x;
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    echo "success";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
?>