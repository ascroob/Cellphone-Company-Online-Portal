<?php  
 require('connect.php');

if (isset($_POST['username']) and isset($_POST['password'])){
	
    // Assigning POST values to variables.
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // CHECK FOR THE RECORD FROM TABLE
    $spID = "SELECT serviceProviderID 
            FROM c9.CellProviderCompany 
            WHERE username='$username' 
            AND password='$password'";

     
    $result = mysqli_query($db, $spID) or die(mysqli_error($db));
    $count = mysqli_num_rows($result);
    
//STILL NEED TO: show valid/invalid pop-up
//user can bypass login through URL


    if ($count == 1){
    
        //echo "Login Credentials verified";
        echo "<script type='text/javascript'>alert('Login Credentials verified')</script>";
        
     /*   $view = "CREATE VIEW ProviderCustomer 
                    AS SELECT * 
                    FROM Customer
                    WHERE ServiceProviderID = $spID";
    
          */          
        header("Location: public/index.php");
    
    }else{
        echo "<script type='text/javascript'>alert('Invalid Login Credentials')</script>";
        //echo "Invalid Login Credentials";
       header("Location: login.php");
    }
};
?>


 