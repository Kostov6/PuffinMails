<?php 
    require ('php/authorization.php');    
    require ('php/db.php');

    $db = new Db('webproject','');

    $sql = "SELECT inboxId, seen, message.msgId, msgType, content, senderId FROM inboxmessages INNER JOIN message ON inboxmessages.msgId = message.msgId WHERE msgType != 6 AND msgType != 7 AND msgType != 8";
    $messages = $db->select($sql, []);
    $lengths = array_map(function ($message) {
        return mb_strlen($message['content'], 'UTF-8');
    }, $messages);
    $seenNumber = count(array_filter($messages, function ($message) {
        if ($message['seen']) {
            return true;
        }
        return false;
    }));

    $statistics['seenPercentage'] = ($seenNumber/count($messages))*100;

    $sql = "SELECT inboxId, message.msgId, msgType, senderId FROM inboxmessages INNER JOIN message ON inboxmessages.msgId = message.msgId INNER JOIN users ON users.userID = message.senderId WHERE msgType = 4";
    $groupMessages = $db->select($sql, []);

    //find group with most messages
    //find threme with most recensions
    //find users with most sent messages

    $averageCharsPerMsg = floor(array_sum($lengths)/count($lengths));

    $messageCount = count($messages);
    $recMsgCount = count(array_filter($messages, function ($message) {
        return $message['msgType'] == 1;
    }));
    $normalMsgCount = count(array_filter($messages, function ($message) {
        return $message['msgType'] == 0;
    }));
    $groupMsgCount = count(array_filter($messages, function ($message) {
        return $message['msgType'] == 4;
    }));

    $statistics['averageChars'] = $averageCharsPerMsg;
    $statistics['messageCount'] = $messageCount; 
    $statistics['normalMsgCount'] = $normalMsgCount; 
    $statistics['recMsgCount'] = $recMsgCount; 
    $statistics['groupMsgCount'] = $groupMsgCount; 
?>