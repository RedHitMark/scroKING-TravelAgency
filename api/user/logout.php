<?php
    session_start();
    session_destroy();
 
    header("location:/index.htm");
    exit();
?>