<?php
    include '../common/common.php';
    include 'groupCommons.php';


    function removeGroup($leader)
    {
        $db = new Db("webproject",'');
        
        //get leader ID
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$leader]);
        $leaderId=$result[0]["userID"];
        //get group id
        $result=$db->select("SELECT groupId FROM groups WHERE leaderId = ?",[$leaderId]);
        $groupId=$result[0]["groupId"];
        

        //set users member_of to NULL
         $db->insert("UPDATE users SET member_of = NULL WHERE member_of = ?",[$groupId]);

         //remove group
         $db->insert("DELETE FROM groups WHERE groupId = ?",[$groupId]);
        echo '{"status":"Group removed successfully"}';
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
        echo "You are not in a group";
    }
    else if(!isLeader($cookie))
    {
        echo "You are not the leader";
    }
    else
    {
        removeGroup($cookie);
    }
?>