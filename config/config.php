<?php

    define("HOST", "den1.mysql6.gear.host");
    define("USERNAME", "skd");
    define("PASSWORD", "Qr5h8B-?oYI4");
    define("DATABASE", "skd");

    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);

    if(!$conn){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>
