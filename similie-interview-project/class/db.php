<?php
    // Database configuration
    $dbHost     = "localhost";
    $dbUsername = "root";
    $dbPassword = "DDee@2022@DD";
    $dbName     = "similie_db";

    // Create database connection
    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: ");
    }
