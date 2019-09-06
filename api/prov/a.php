<?php
    include_once("../config/Snoopy.class.php");

    $snop = new Snoopy();

    echo(json_encode($snop->fetchtext("http://192.168.1.126:56785/login")));