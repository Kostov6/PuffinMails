<?php
    include '../common/common.php';
    include 'groupCommons.php';
    
    function sameGroups($leader,$user)
    {
        
        $db = new Db();
        $result=$db->select("SELECT member_of FROM users WHERE username=?",[$leader]);
        $groupId1=$result[0]["member_of"];
        
        $result=$db->select("SELECT member_of FROM users WHERE username=?",[$user]);
        $groupId2=$result[0]["member_of"];

        return $groupId1 == $groupId2;
       
    }

    function remove($user)
    {
        $db = new Db();
        
        //get users ID
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $id=$result[0]["userID"];

        //set user's member_of to NULL
         $db->insert("UPDATE users SET member_of = NULL WHERE userId = ?",[$id]);
        
        echo '{"status":"User removed"}';
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
        echo "You are not in group";
    }
    else if(!isLeader($cookie))
    {
        echo "You are not the leader of the group";
    }
    else if(!isValidUser($user))
    {
        echo "User is not valid";
    }
    else if(!isInGroup($user))
    {
        echo "User is not in a group";
    }
    else if(!sameGroups($cookie,$user))
    {
        echo "User is not in the same group";
    }
    else if(isUserSelf($cookie,$user))
    {
        echo "You cannot remove yourself from your group";
    }
    else
    {
        remove($user);
    }
?>