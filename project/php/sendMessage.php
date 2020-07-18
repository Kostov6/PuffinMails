<?php 
    function sendMessage($senderId, $receiverIds, $msgType, $title, $content, $db) {
        if (!is_array($receiverIds)) {
            $receiverIds = [$receiverIds];
        }

        $sql = "INSERT INTO message(senderId, msgType, title, content) VALUES (?, ?, ?, ?)";
        $db->insert($sql, [$senderId, $msgType, $title, $content]);
        
        $sql = "SELECT MAX(`msgId`) FROM message WHERE senderId = ?";
        $msgId = $db->select($sql,[$senderId])[0]['MAX(`msgId`)'];

        $sql = "INSERT INTO inboxmessages (inboxId, msgId) VALUES ";
        $param = array();
        $receiversCount = count($receiverIds);

        $queryPart = array_fill(0, $receiversCount, "(?, ?)");
        $sql .=  implode(",",$queryPart);

        for ($i = 0; $i < $receiversCount; ++$i) {
            $param = array_merge($param, [$receiverIds[$i], $msgId]);
        }

        $db->insert($sql, $param);
    }
?>