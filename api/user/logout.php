<?php
    include_once("../config/session.php");
     sessionInit();
     sessionDestroy();

    // response: 401 Unauthorized
    http_response_code(401);
?>
