<?php
    include '../common/common.php';
    include 'groupCommons.php';

    $cookie="";
    if(isset($_GET["cookie"]))
        $cookie = $_GET["cookie"];

    if(!validateSession($cookie))
    {
        echo "Invalid cookie";
    }
    else if(!isInGroup($cookie))
    {
        $state="noGroupUser";
    }    
    else if(!isLeader($cookie))
    {
        $state="groupUser";
    }
    else
    {
        $state="leader";
    }

    echo '{"state":"'.$state.'"}';
?>