<?php
   session_start();
   if($_SESSION['log'] != 'login'){
      header('Location:NEW.html');
      exit('尚未登入<a href="NEW.html">回首頁</a>');
   }
    require_once('config.php');
    $id = $_POST['id'];
    try{
        $sql = "DELETE FROM danielwu WHERE id=".$id;
        $conn->exec($sql);
        echo 'success';
    }
    catch(PDOException $e){
        echo $sql . '<br>' .$e->getMessage();
    }
    $conn = null;
?>