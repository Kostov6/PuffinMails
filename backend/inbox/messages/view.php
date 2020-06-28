<?php
    include '../common/common.php';

    function isPositiveInteger($string)
    {
        $result=filter_var($string,FILTER_VALIDATE_INT);
        if(!$result)
            return false;
        return $result >= 0;
    }

    function existsId($msgId)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM message WHERE msgId = ?",[$msgId]);
        return count($result) == 1;
    }
    function isMessageIdInUserInbox($msgId,$cookie)
    {
        $db = new Db("webproject",'');
        $result=$db->select(" SELECT u.userID,m.msgId FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId WHERE u.faculty_number=? AND m.msgId=?",[$cookie,$msgId]);
        return count($result) == 1;
    }
    
    function viewMessage($msgId)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM message WHERE msgId = ?",[$msgId]);
        echo json_encode($result);
    }

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

        
    $id="";
    if(isset($_GET["id"]))
        $id = $_GET["id"];


    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(!isPositiveInteger($id))
    {
        echo "Id is not a positive integer";
    }
    else if(!existsId($id))
    {
        echo "Id does not exist";
    }
    else if(!isMessageIdInUserInbox($id,$cookie))
    {
        echo "id does not belong to user's inbox";
    }
    else
    {
        viewMessage($id);
    }
?>