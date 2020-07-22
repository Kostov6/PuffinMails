<?php
    include '../common/common.php';
    include 'contactCommons.php';

    function addUser($user,$contact)
    {

        $db = new Db();
        
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $id1=$result[0]["userID"];
        
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$contact]);
        $id2=$result[0]["userID"];

        $result=$db->insert("INSERT INTO contactlist values (?,?)",[$id1,$id2]);
        echo '{"status":"User added"}';
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
    else if(!isValidUser($user))
    {
        echo "Invalid user field";
    }
    else if(isUserSelf($cookie,$user))
    {
        echo "Cannot add yourself in contact list";
    }
    else if(isUserInContacts($cookie,$user))
    {
        echo "User is already in contacts";
    }
    else
    {
        addUser($cookie,$user);
    }
?>