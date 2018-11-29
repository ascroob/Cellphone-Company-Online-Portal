<?php  
 require('connect.php');

if (isset($_POST['username']) and isset($_POST['password'])){
	
    // Assigning POST values to variables.
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $connection = mysql_connect($servername, $host, $pass);
	
    // CHECK FOR THE RECORD FROM TABLE
    $mysql = "SELECT serviceProviderID 
        FROM c9.CellProviderCompany 
        WHERE username='$username' 
        AND password='$password'";
        
    $view = "CREAT VIEW ServiceProvider
            FROM c9.Customer
            WHERE serviceProviderID = $mysql";
    
    $result = mysqli_query($db, $mysql) or die(mysqli_error($db));
    $count = mysqli_num_rows($result);


    if ($count == 1){
        echo "<script type='text/javascript'>alert('Login Credentials verified')</script>";
        header("location: public/index.php");
    
    }else{
        echo "Invalid Login Credentials";
        header("Location: login.php");
        echo "<script type='text/javascript'>alert('Invalid Login Credentials')</script>";
    }
};
?>