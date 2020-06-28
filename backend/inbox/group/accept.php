<?php
    include '../common/common.php';
    include 'groupCommons.php';

    function acceptInvite($user,$leader)
    {
        $db = new Db("webproject",'');
        
        //get leader ID
        $result=$db->select("SELECT userID FROM users WHERE faculty_number = ?",[$leader]);
        $leaderId=$result[0]["userID"];
        //get user id
        $result=$db->select("SELECT userID FROM users WHERE faculty_number = ?",[$user]);
        $userId=$result[0]["userID"];
        //get group id
        $result=$db->select("SELECT member_of FROM users WHERE faculty_number = ?",[$leader]);
        $groupId=$result[0]["member_of"];

        //check if invitation exists
        $result=$db->select("SELECT * FROM invites WHERE leaderId=? AND userId=?",[$leaderId,$userId]);
        if(count($result) == 1)
        {
            //invite exists
            //delete invite
            $db->insert("DELETE FROM invites WHERE leaderId=? AND userId=?",[$leaderId,$userId]);
            //set member_of of user
            $db->insert("UPDATE users SET member_of=? WHERE userId=?",[$groupId,$userId]);
           
            echo "Invitation accepted. You are now part of a group";
        }
        else
        {
            echo "You have not been invited by this leader";
        }
    }

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

    $leader="";
    if(isset($_GET["leader"]))
        $leader = $_GET["leader"];

    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(isInGroup($cookie))
    {
        echo "User is already in group and can't accept invitations";
    }
    else if(!isValidUser($leader))
    {
        echo "Leader is not a valid user";
    }
    else if(!isLeader($leader))
    {
        echo "Leader field is not a leader";
    }
    else
    {
        acceptInvite($cookie,$leader);
    }
?>