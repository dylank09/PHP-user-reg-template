<?php

    session_start();

    if (!(isset($_SESSION["loggedin"])) || $_SESSION["loggedin"] == false) {
        header( "Location: login.html" );
    } 

?>

<html>
    <head>
        <title>Fully</title>

    </head>

    <body>
        <button type="button" class="button" onClick="location.href='logout.php'">
            Log Out
        </button>
    </body>
</html>