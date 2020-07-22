<?php
    include '../common/common.php';
    $db = new Db();
    
    $body=(array) json_decode(file_get_contents('php://input'));
    $senderName = $body["sender"];
    $receiverName = $body["receiver"];
    $msgType = $body["msgType"];
    $title = $body["title"];
    $content = $body["content"];

    if(is_numeric($receiverName))
    {
        $result=$db->select("SELECT username FROM users where number_theme = ?",[$receiverName]);
        $receiverName=$result[0]["username"];
    }

    $sql = "SELECT userID FROM users WHERE username = ?";
    $senderId = $db->select($sql, [$senderName])[0]['userID'];

    $sql = "SELECT userID, first_name, last_name FROM users WHERE username = ?";
    $reported = $db->select($sql, [$receiverName])[0];

    $sql = "INSERT INTO message (msgType, title, content, senderId) VALUES (?, ?, ?, ?)";
    $db->insert($sql, [7,
    "Докладване на " . $reported['first_name'] . " " . $reported['last_name'],
    $reported['first_name'] . " " . $reported['last_name'] . " написа: '" . $content . "'",
    $senderId]);
    
    $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
    $msgId = $db->select($sql,[$senderId])[0]['MAX(`msgId`)'];

    $sql = "INSERT INTO inboxmessages (inboxId, msgId) VALUES (?, ?)";
    $db->insert($sql, [$reported['userID'], $msgId]);
    
    echo '{"status":"ok"}';
    //echo '{"status":"error"}';

?>