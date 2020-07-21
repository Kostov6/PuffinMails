<?php 
    require ('php/authorization.php');    
    require ('php/db.php');

    $db = new Db('webproject','');

    $sql = "SELECT inboxId, seen, message.msgId, msgType, content, senderId FROM inboxmessages INNER JOIN message ON inboxmessages.msgId = message.msgId WHERE msgType != 6 AND msgType != 7 AND msgType != 8";
    $messages = $db->select($sql, []);
    $lengths = [];
    $seenNumber = 0;

    if (!isset($messages)) {
        $messages = [];
    } else {
        $lengths = array_map(function ($message) {
            return mb_strlen($message['content'], 'UTF-8');
        }, $messages);
        $seenNumber = count(array_filter($messages, function ($message) {
            if ($message['seen']) {
                return true;
            }
            return false;
        }));
    }

    if (count($messages) != 0) {
        $statistics['seenPercentage'] = round(($seenNumber/count($messages))*100);
    } else {
        $statistics['seenPercentage'] = 0;
    }
    
    $sql = "SELECT count(msgId), member_of FROM message INNER JOIN users ON users.userID = message.senderId WHERE msgType = 4 GROUP BY member_of ORDER BY count(msgId) DESC";
    $groupMostMessages = $db->select($sql, []);

    if (!empty($groupMostMessages)) {
        $groupMostMessages = $groupMostMessages[0];
    }

    if (isset($groupMostMessages['member_of'])) {
        $statistics['groupMostMsgs'] = $groupMostMessages['member_of'];
    } else {
        $statistics['groupMostMsgs'] = 'Няма групови съобщения!';
    }

    if (isset($groupMostMessages['count(msgId)'])) {
        $statistics['mostGroupMsgs'] = $groupMostMessages['count(msgId)'];
    } else {
        $statistics['mostGroupMsgs'] = 0;
    }

    $sql = "SELECT count(message.msgId), number_theme FROM inboxmessages INNER JOIN message ON inboxmessages.msgId = message.msgId INNER JOIN users ON inboxmessages.inboxId = users.userID WHERE msgType = 1 GROUP BY number_theme ORDER BY count(message.msgId) DESC";
    $mostRecTheme = $db->select($sql, []);

    if (!empty($mostRecTheme)) {
        $mostRecTheme = $mostRecTheme[0];
    }

    if (isset($mostRecTheme['number_theme'])) {
        $statistics['mostRecTheme'] = $mostRecTheme['number_theme'];
    } else {
        $statistics['mostRecTheme'] = 'Няма рецензии!';
    }

    if (isset($mostRecTheme['count(message.msgId)'])) {
        $statistics['mostRecOnTheme'] = $mostRecTheme['count(message.msgId)'];
    } else {
        $statistics['mostRecOnTheme'] = 0;
    }

    $sql = "SELECT username, count(msgId) FROM message INNER JOIN users ON senderId = userID WHERE userID != 4 GROUP BY senderId ORDER BY count(msgId) DESC";
    $userMostMsgSent = $db->select($sql, []);
    
    if (!empty($userMostMsgSent)) {
        $userMostMsgSent = $userMostMsgSent[0]['username'];
    } else {
        $userMostMsgSent = 'Няма изпратени съобщения!';
    }

    $statistics['userMostMsgSent'] = $userMostMsgSent;

    if (empty($lengths)) {
        $averageCharsPerMsg = 0;
    } else {
        $averageCharsPerMsg = floor(array_sum($lengths)/count($lengths));
    }

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