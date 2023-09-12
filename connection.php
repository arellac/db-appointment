<?php

    $database= new mysqli("localhost","root","","db_project");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>