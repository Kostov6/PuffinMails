<?php   
    include '../common/common.php';
    include 'contactCommons.php';

    function removeUser($user,$contact)
    {
        echo $user." ".$contact;
        $db = new Db("webproject",'');

        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$user]);
        $id1=$result[0]["userID"];
        
        $result=$db->select("SELECT userID FROM users WHERE username = ?",[$contact]);
        $id2=$result[0]["userID"];

        $result=$db->insert("DELETE FROM contactlist WHERE userId = ? AND contactId = ?",[$id1,$id2]);
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
    else if(!isValidUser($user))
    {
        echo "Invalid user field";
    }
    else if(isUserSelf($cookie,$user))
    {
        echo "Cannot remove yourself from contact list";
    }
    else if(!isUserInContacts($cookie,$user))
    {
        echo "Cannot remove user that is not in contact list";
    }
    else
    {
        removeUser($cookie,$user);
    }
?>