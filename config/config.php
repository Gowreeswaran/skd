<?php

    define("HOST", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASE", "skd");

    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);

    if(!$conn){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>