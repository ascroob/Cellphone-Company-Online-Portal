   <?php
        if(isset($_POST['submit'])){
            $selected_val = $_POST['formSPID'];  // Storing Selected Value In Variable
            echo "You have selected :" .$selected_val;  // Displaying Selected Value
     }?>
<?php
 //   include('authen_login.php'); // Includes Login Script
    
  //  if(isset($_SESSION['login'])){
    //    header("location: public/index.php");
    //}
?>

<!DOCTYPE html >
<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body id="body_bg">
<div <div align="center">

<h3>Login</h3>
    <form id="login-form" method="post" action="authen_login.php" >
        <table border="0.5" >
            <tr>
                <td><label for="username">Username</label></td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" name="password" id="password"></input></td>
            </tr>
			
			<form action="#" method="post">
			<p>Service Provider ID
            <select name="select" id = "formSPID">
              <option value="">Select...</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
            </select>
            </p>
            </form>
            
            <tr>
                <td><input type="submit" value="submit" />
				
            </tr>
        </table>
    </form>
		</div>
</body>
</html>
<?php} ?>