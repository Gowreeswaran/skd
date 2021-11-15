<?php


    session_start();

    date_default_timezone_set("Asia/Colombo");
    include_once '../config/config.php';
    include_once 'functions.php';

    session_destroy();

    header('Location: ../index.php');



?>