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

    $statistics['seenPercentage'] = round(($seenNumber/count($messages))*100);

    $sql = "SELECT count(msgId), member_of FROM message INNER JOIN users ON users.userID = message.senderId WHERE msgType = 4 GROUP BY member_of ORDER BY count(msgId) DESC";
    $groupMostMessages = $db->select($sql, [])[0];

    $statistics['groupMostMsgs'] = $groupMostMessages['member_of'];
    $statistics['mostGroupMsgs'] = $groupMostMessages['count(msgId)'];

    $sql = "SELECT count(message.msgId), number_theme FROM inboxmessages INNER JOIN message ON inboxmessages.msgId = message.msgId INNER JOIN users ON inboxmessages.inboxId = users.userID WHERE msgType = 1 GROUP BY number_theme ORDER BY count(message.msgId) DESC";
    $mostRecTheme = $db->select($sql, [])[0];

    $statistics['mostRecTheme'] = $mostRecTheme['number_theme'];
    $statistics['mostRecOnTheme'] = $mostRecTheme['count(message.msgId)'];

    $sql = "SELECT username, count(msgId) FROM message INNER JOIN users ON senderId = userID WHERE userID != 4 GROUP BY senderId ORDER BY count(msgId) DESC";
    $userMostMsgSent = $db->select($sql, [])[0]['username'];

    $statistics['userMostMsgSent'] = $userMostMsgSent;

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