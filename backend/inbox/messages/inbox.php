<?php
    include '../common/common.php';

    
    function isValidFilter($filter)
    {
        $result=filter_var($filter,FILTER_VALIDATE_INT);
        if(!$result)
            return false;
        return $result >= 0 && $result <= 8 && $result !=7;
    }

    function viewInbox($cookie,$filter)
    {
        $db = new Db();
        $result=$db->select("SELECT m.msgType,m.msgId,m.title,m.time_sent,u2.username as sender,seen FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId INNER JOIN users u2 on m.senderId = u2.userId WHERE u.username=? AND m.msgType=? ORDER BY time_sent DESC",[$cookie,$filter]);
        $result=anonymize($result);

        echo json_encode($result);
    }

    function anonymize($result)
    {
        $db = new Db();
        for($i=0;$i<count($result);$i++)
        {
            if($result[$i]["msgType"] == 1 || $result[$i]["msgType"] == 2)
            {
                //анонимизиране на изпращача
                $row=$db->select("SELECT number_theme FROM users WHERE username = ?",[$result[$i]["sender"]]);
                $result[$i]["sender"] = $row[0]["number_theme"];
            }
        }
        //var_dump($result);
        return $result;
    }

    function viewAll($cookie)
    {
        $db = new Db();
        $result=$db->select("SELECT m.msgType,m.msgId,m.title,m.time_sent,u2.username as sender,seen  FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId INNER JOIN users u2 on m.senderId = u2.userId WHERE u.username=? AND m.msgType != 7 AND m.msgType != 6 ORDER BY time_sent DESC",[$cookie]);
        $result=anonymize($result);

        echo json_encode($result);

    }

    function viewSendMessages($cookie)
    {
        $db = new Db();
        $result=$db->select("SELECT userId FROM users WHERE username = ?",[$cookie]);
        $userId=$result[0]["userId"];

        
        $result=$db->select("SELECT msgType,msgId,title,time_sent FROM message WHERE msgType != 7 AND msgType!=6 AND senderId=?",[$userId]);
        foreach($result as &$row)
        {
            $row["sender"] = $cookie;
            $row["seen"] = 1;
    
        }
        $result=anonymize($result);
        
        echo json_encode($result);
    }
    
    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

        
    $filter="";
    if(isset($_GET["filter"]))
        $filter = $_GET["filter"];


    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if($filter == "")
    {
        viewAll($cookie);
    }
    else if($filter == "send")
    {
        viewSendMessages($cookie);
    }
    else if(!isValidFilter($filter))
    {
        echo "filter is not valid";
    }
    else
    {
        viewInbox($cookie,$filter);
    }
?>