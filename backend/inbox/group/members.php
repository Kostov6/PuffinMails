<?php
    include '../common/common.php';
    include 'groupCommons.php';

    function getGroupMembers($user)
    {
        $db = new Db("webproject",'');
        
        //get group ID
        $result=$db->select("SELECT member_of FROM users WHERE username = ?",[$user]);
        $groupId=$result[0]["member_of"];


        //get leader ID
        $result=$db->select("SELECT leaderId FROM groups WHERE groupId = ?",[$groupId]);
        $leaderId=$result[0]["leaderId"];

        $firstNames = array();
        $usernames = array();
        $result=$db->select("SELECT first_name FROM users WHERE userId = ?",[$leaderId]);
        array_push($firstNames,$result[0]["first_name"]);

        $result=$db->select("SELECT username FROM users WHERE userId = ?",[$leaderId]);
        array_push($usernames,$result[0]["username"]);

        $result=$db->select("SELECT first_name FROM users WHERE member_of = ? AND userId != ?",[$groupId,$leaderId]);
        foreach($result as $row){
            array_push($firstNames,$row["first_name"]);
        }

        $result=$db->select("SELECT username FROM users WHERE member_of = ? AND userId != ?",[$groupId,$leaderId]);
        foreach($result as $row){
            array_push($usernames,$row["username"]);
        }


        echo json_encode(array("firstNames" => $firstNames,"usernames" => $usernames));
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
        echo "User is not in group";
    }
    else
    {
        getGroupMembers($cookie);
    }
?>