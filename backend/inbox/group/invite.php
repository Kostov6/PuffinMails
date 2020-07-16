<?php
    include '../common/common.php';
    include 'groupCommons.php';

    function inviteUser($leader,$user)
    {
        $db = new Db("webproject",'');
        
        //get leader ID
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$leader]);
        $leaderId=$result[0]["userID"];
        //get user id
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $userId=$result[0]["userID"];
        
        //set crate invite
         $db->insert("INSERT INTO invites VALUES (?,?)",[$leaderId,$userId]);

        echo '{"status":"User invited"}';
    }

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

    $user="";
    if(isset($_GET["user"]))
        $user = $_GET["user"];

    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(!isInGroup($cookie))
    {
        echo "Cannot invite because you are not in a group";
    }
    else if(!isLeader($cookie))
    {
        echo "Cannot invite because you are not the leader of the group";
    }
    else if(!isValidUser($user))
    {
        echo "User you are trying to invite is not valid";
    }
    else if(isUserSelf($cookie,$user))
    {
        echo "You cannot invite yourself";
    }
    else if(isInGroup($user))
    {
        echo "User is already in group";
    }
    else
    {
        inviteUser($cookie,$user);
    }
?>