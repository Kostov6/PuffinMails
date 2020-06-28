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
        $result=$db->select("SELECT m.* FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId WHERE u.faculty_number=? AND m.msgType=?",[$cookie,$filter]);
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