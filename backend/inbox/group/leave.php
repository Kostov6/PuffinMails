<?php
    include '../common/common.php';
    include 'groupCommons.php';

    function leaveGroup($user)
    {
        $db = new Db("webproject",'');
        
        //get users ID
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $id=$result[0]["userID"];

        //set user's member_of to NULL
         $db->insert("UPDATE users SET member_of = NULL WHERE userId = ?",[$id]);
        
        echo '{"status":"User left the group"}';
    }

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(!isInGroup($cookie))
    {
        echo "User is not in group to leave";
    }
    else if(isLeader($cookie))
    {
        echo "Cannot leave the group when you are the leader";
    }
    else
    {
        leaveGroup($cookie);
    }
?>