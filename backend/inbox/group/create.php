<?php
    include '../common/common.php';
    include 'groupCommons.php';

    function createGroup($user)
    {
        $db = new Db("webproject",'');
        
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $id=$result[0]["userID"];

        //create the group with the leader as user
        $db->insert("INSERT INTO groups (leaderId) values (?)",[$id]);
        
        $result=$db->select("SELECT groupId FROM groups WHERE leaderId = ?",[$id]);
        $groupId=$result[0]["groupId"];
        
        //set memeber_of of the leader
        $db->insert("UPDATE users SET member_of = ? WHERE userId = ?",[$groupId,$id]);
        
        echo '{"status":"Group created successfully"}';
    }

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];


    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(isInGroup($cookie))
    {
        echo "Cannot create group because you are already in a group";
    }
    else{
        createGroup($cookie);
    }
?>