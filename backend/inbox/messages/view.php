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
        $result=$db->select(" SELECT u.userID,m.msgId FROM users u INNER JOIN inbox i on u.userID = i.ownerId INNER JOIN inboxmessages iMsg on i.inboxId = iMsg.inboxId INNER JOIN message m on iMsg.msgId = m.msgId WHERE u.username=? AND m.msgId=?",[$cookie,$msgId]);
        return count($result) == 1;
    }
    
    function viewMessage($msgId,$user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT message.*,users.username as sender FROM message INNER JOIN users on users.userId=message.senderId WHERE msgId = ?",[$msgId]);
        $msgType=$result[0]["msgType"];
        $sender=$result[0]["sender"];
        $senderName=$result[0]["sender"];
        $title=$result[0]["title"];
        $content=$result[0]["content"];

        //seen
        $result=$db->select("SELECT inboxId FROM inbox INNER JOIN users on inbox.ownerId=users.userId WHERE username = ?",[$user]);
        $inboxId=$result[0]["inboxId"];
        $db->insert("UPDATE inboxmessages SET seen = TRUE WHERE inboxId=? AND msgId=?",[$inboxId,$msgId]);


        if($msgType == 1 || $msgType == 2)
        {
            //анонимизиране на изпратилия
            if($sender != $user)
            {
                //анонимизиране на изпращача
                $result=$db->select("SELECT number_theme FROM users WHERE username = ?",[$sender]);
                $sender=$result[0]["number_theme"];
            }
            
        }
        $receivers = "";
        $result=$db->select("SELECT username  FROM message INNER JOIN inboxmessages on message.msgId = inboxmessages.msgId INNER JOIN inbox on inbox.inboxId = inboxmessages.inboxId 
            INNER JOIN users on users.userId = inbox.ownerId WHERE message.msgId = ?",[$msgId]);
        foreach($result as $receiverArray)
        {
            if($senderName != $receiverArray["username"])
            {
                $receivers = $receiverArray["username"]." ".$receivers;
            }
        }
        if($msgType == 1 || $msgType == 3)
        {
            $receivers = "";
            //анонимизиране на получателите
            foreach($result as $receiverArray)
            {
                if($senderName != $receiverArray["username"])
                {
                    if($receiverArray["username"] != $user )
                    {
                        $row = $db->select("SELECT number_theme FROM users WHERE username = ?",[$receiverArray["username"]]);
                        $anonimousUser = $row[0]["number_theme"];
                        $receivers = $anonimousUser." ".$receivers;
                    }
                    else
                    {
                        $receivers = $user." ".$receivers;
                    }
                }
            }
        }
        echo json_encode(array("sender" => $sender, "receivers" => $receivers, "title" => $title, "content" => $content));

/*
        $result=$db->select("SELECT username  FROM message INNER JOIN inboxmessages on message.msgId = inboxmessages.msgId INNER JOIN inbox on inbox.inboxId = inboxmessages.inboxId 
        INNER JOIN users on users.userId = inbox.ownerId WHERE message.msgId = ?",[$msgId]);
        foreach($result as $receiverArray)
        {
            if($receiverArray["username"] != $user)
            {
                echo $receiverArray["username"];
            }
        }
*/
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
        viewMessage($id,$cookie);
    }
?>