<?php

    $severname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projectsmartcard";

    //create connection
    $conn = mysqli_connect($severname, $username, $password, $dbname);

    //checking connection
    if(!$conn){
        die("connection failed" . mysqli_connect_error());
    }

?>