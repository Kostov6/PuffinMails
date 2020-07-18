<?php 
    require ('authorization.php');
    require ('db.php');

    if (!isset($_GET['userId'])) {
        header('Location: reports.php');
        exit();
    }

    $db = new Db('webproject','');

    $userId = $_GET['userId'];

    $sql = "UPDATE users SET ban_until = NULL WHERE userID = ?";
    $db->insert($sql, [$userId]);
    
    header('Location: reports.php');
?>