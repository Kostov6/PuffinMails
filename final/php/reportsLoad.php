<?php
    require ('authorization.php');    
    require ('../backend/inbox/common/db.php');

    $db = new Db();

    $userId = $_SESSION['userID'];

    $sql = "SELECT message.*, first_name, last_name FROM message INNER JOIN users ON message.senderId = users.userID WHERE msgType = 7 ORDER BY message.time_sent DESC";
    $reports = $db->select($sql,[]);

    $sql = "SELECT userID, first_name, last_name, faculty_number, ban_until FROM users WHERE ban_until > CURRENT_DATE()";
    $bannedUsers = $db->select($sql, []);
?>