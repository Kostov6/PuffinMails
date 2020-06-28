<?php


    function isUserInContacts($user,$contact)
    {

        $db = new Db("webproject",'');
        $result=$db->select
        ("SELECT u1.faculty_number as faculty_number_owner, u2.faculty_number as faculty_number_contact FROM users u1 INNER JOIN contactList cl on u1.userID=cl.userID INNER JOIN users u2 on cl.contactID=u2.userID WHERE u1.faculty_number = ? AND u2.faculty_number = ?",[$user,$contact]);
        if(count($result)==1)
            return true;
        return false;
    }


?>