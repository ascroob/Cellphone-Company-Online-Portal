<?php
    require "connect.php";
    require "authen_login.php";
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
    $connection = new PDO($dsn, $host, $pass, $options);
    session_start();// Starting Session
    // Storing Session
    $username=$_SESSION['login'];
    // SQL Query To Fetch Complete Information Of User
    $ses_sql=mysql_query("SELECT serviceProviderID 
            FROM c9.CellProviderCompany 
            WHERE username= $username
            AND password=$password", $connection);
    $row = mysql_fetch_assoc($ses_sql);
    $login_session =$row['username'];
    if(!isset($login_session)){
        mysql_close($connection); // Closing Connection
        header('Location: ../login.php'); // Redirecting To Home Page
    }
?>

<!--code from https://www.formget.com/login-form-in-php/-->
<!-- when a user succesfully logs in, store their session-->