<?php
    include '../common/common.php';

    
    function isValidFilter($filter)
    {
        $result=filter_var($filter,FILTER_VALIDATE_INT);
        if(!$result)
            return false;
        return $result >= 0 && $result <= 8;
    }

    function viewInbox($cookie,$filter)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT m.msgId,m.title,m.date_send,u2.username FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId INNER JOIN users u2 on m.senderId = u2.userId WHERE u.username=? AND m.msgType=? ORDER BY date_send DESC",[$cookie,$filter]);
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
    else if(!isValidFilter($filter))
    {
        echo "filter is not valid";
    }
    else
    {
        viewInbox($cookie,$filter);
    }
?>