<?php
   session_start();
   if($_SESSION['log'] != 'login'){
      header('Location:NEW.html');
      exit('尚未登入<a href="NEW.html">回首頁</a>');
   }
    require_once('config.php');

    $appid = empty($_POST['appid']) ? '还未输入内容' : $_POST['appid'];
    $appname = empty($_POST['appname']) ? '还未输入内容' : $_POST['appname'];
    $isshowwap = '0';
    $wapurl = empty($_POST['wapurl']) ? '还未输入内容' : $_POST['wapurl'];
    $status = '1';
    $qwe = empty($_POST['qwe']) ? '还未输入内容' : $_POST['qwe'];
    $tt = empty($_POST['tt']) ? '还未输入内容' : $_POST['tt'];
    if( $_POST['add'] == 'add' ){
    try {
        $sql = "INSERT INTO  danielwu(appid,appname,isshowwap,wapurl,status,qwe,tt)
        VALUES (?, ?,?,?,?,?,?)";
        $final = $conn->prepare($sql);
        $final->bindParam(1,$appid,PDO::PARAM_STR,50);
        $final->bindParam(2,$appname,PDO::PARAM_STR,50);
        $final->bindParam(3,$isshowwap,PDO::PARAM_STR,5);
        $final->bindParam(4,$wapurl,PDO::PARAM_STR,50);
        $final->bindParam(5,$status,PDO::PARAM_STR,5);
        $final->bindParam(6,$qwe,PDO::PARAM_STR,50);
        $final->bindParam(7,$tt,PDO::PARAM_STR,50);
        $final->execute();
        echo 'success';
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
    }
?>