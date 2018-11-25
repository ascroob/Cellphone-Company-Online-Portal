<?php
    // A simple PHP script demonstrating how to connect to MySQL.
    // Press the 'Run' button on the top to start the web server,
    // then click the URL that is emitted to the Output tab of the console.

    $servername = 'localhost';
    $username = getenv('C9_USER');
    $password = "";
    $dbname = "c9";
    $dbport = 3306;
    $dsn        = "mysql:host=$servername;database=$dbname"; // will use later
    $options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);

  /*  // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
    echo "Connected successfully (".$db->host_info.")";
    */