<?php


    function isUserInContacts($user,$contact)
    {

        $db = new Db("webproject",'');
        $result=$db->select
        ("SELECT u1.username as username_owner, u2.username as username_contact FROM users u1 INNER JOIN contactList cl on u1.userID=cl.userID INNER JOIN users u2 on cl.contactID=u2.userID WHERE u1.username = ? AND u2.username = ?",[$user,$contact]);
        if(count($result)==1)
            return true;
        return false;
    }


?>