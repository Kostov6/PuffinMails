<?php
    include '../common/common.php';
    $db = new Db("webproject",'');
    
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

    
    echo '{"status":"ok"}';
    //echo '{"status":"error"}';

?>