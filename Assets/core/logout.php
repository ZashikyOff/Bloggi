<?php
    session_name("bloggi");
    session_start();
    session_destroy();
    header("Location: ../../index.php");
