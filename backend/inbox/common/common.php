<?php
    include 'db.php';

    function isUserSelf($cookie,$user)
    {
        return $cookie==$user;
    }

    function validateSession($cookie)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM users WHERE faculty_number = ?",[$cookie]);
        if(count($result)==1)
            return true;
        return false;
    }

    function isValidUser($user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM users WHERE faculty_number = ?",[$user]);
        if(count($result)==1)
            return true;
        return false;
    }

    function isNameFromat($name)
    {
        
    }

?>