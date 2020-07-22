<?php
    include '../common/common.php';

    function allContacts($user)
    {
        $db = new Db();
        
        $result=$db->select("SELECT u2.first_name,u2.last_name,u2.username FROM users u1 INNER JOIN contactlist cl on u1.userID = cl.userId INNER JOIN users u2 on cl.contactId = u2.userID WHERE u1.username=?",[$user]);
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
        allContacts($cookie);
    }
?>