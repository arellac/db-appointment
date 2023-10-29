<?php

    $database= new mysqli("localhost","root","","book-look");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>