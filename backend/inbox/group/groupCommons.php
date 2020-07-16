<?php

    function isInGroup($user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT userID,username FROM users WHERE member_of IS NOT NULL AND username=?",[$user]);
        return count($result) == 1;
    }

    function isLeader($user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM users INNER JOIN groups on member_of=groups.groupId WHERE username=? AND userID=groups.leaderId",[$user]);
        return count($result) == 1;
    }

?>