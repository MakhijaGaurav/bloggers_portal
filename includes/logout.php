<?php
    session_start();
    $_SESSION['username'] = null;
    $_SESSION['user_role'] = null;
    $_SESSION['user_id'] = null;
    header("Location: ../index.php");
?>