<?php
    include 'db.php';

    function isUserSelf($cookie,$user)
    {
        return $cookie==$user;
    }

    function validateSession($cookie)
    {
        $db = new Db();
        $result=$db->select("SELECT * FROM users WHERE username = ?",[$cookie]);
        if(count($result)==1)
            return true;
        return false;
    }

    function isValidUser($user)
    {
        $db = new Db();
        $result=$db->select("SELECT * FROM users WHERE username = ?",[$user]);
        if(count($result)==1)
            return true;
        return false;
    }

    function isNameFromat($name)
    {
        
    }

?>