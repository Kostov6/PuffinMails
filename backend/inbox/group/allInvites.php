<?php
    include '../common/common.php';

    function allInvites($user)
    {
        $db = new Db();
        
        $result=$db->select("SELECT u1.first_name,u1.username FROM users u1 INNER JOIN invites on u1.userID = invites.leaderId INNER JOIN users u2 on invites.userId = u2.userID WHERE u2.username = ?",[$user]);
        echo json_encode($result);
    }
    
    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];


    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else
    {
        allInvites($cookie);
    }
?>