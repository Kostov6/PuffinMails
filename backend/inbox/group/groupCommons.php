<?php

    function isInGroup($user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT userID,faculty_number FROM users WHERE member_of IS NOT NULL AND faculty_number=?",[$user]);
        return count($result) == 1;
    }

    function isLeader($user)
    {
        $db = new Db("webproject",'');
        $result=$db->select("SELECT * FROM users INNER JOIN groups on member_of=groups.groupId WHERE faculty_number=? AND userID=groups.leaderId",[$user]);
        return count($result) == 1;
    }

?>