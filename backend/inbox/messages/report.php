<?php
    include '../common/common.php';

    $body=(array) json_decode(file_get_contents('php://input'));
    $sender = $body["sender"];
    $receiver = $body["receiver"];
    $msgType = $body["msgType"];
    $title = $body["title"];
    $content = $body["content"];

    

    echo '{"status":"ok"}';
    //echo '{"status":"error"}';


?>