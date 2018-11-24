<?php

require "connect.php";
    
try {
	$connection = new PDO("mysql:host=$host", $username, $password, $options);
	$sql = file_get_contents("data/fulldb2.sql");
	$connection->exec($sql);
	
	echo "Database created and data inserted successfully.";
} catch(PDOException $error) {
	echo $sql . "<br>" . $error->getMessage();
}