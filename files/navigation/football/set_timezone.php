<?php

//set_timezone.php
error_reporting(E_ALL);

session_start();

if(isset($_POST['timezone'])) {
    $_SESSION['user_timezone'] = $_POST['timezone'];
        error_log('Session timezone set to: ' . $_SESSION['user_timezone']);

}

?>