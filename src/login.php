<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<html>
  <head>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

 <link href="public/css/logincss.css" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
  </head>
  <br><br><br><br>
<body id="LoginForm">
<div class="container">
    <h2 align = "center">Cell Provider Portal</h2>
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <h2>Admin Login</h2>
   <p>Please enter your username and password</p>
   </div>
    <form id="Login" method = "post" action = "authen_login.php">

        <div class="form-group">

                <td><label for="username">Username</label></td>
                <td><input type="text" name="username" id="username"></td>

        </div>

        <div class="form-group">

             <td><label for="password">Password</label></td>
             <td><input type="password" name="password" id="password"></input></td>

        </div>
     
        <input type="submit" value = "Login">

    </form>
    </div>
</div></div></div>


</body>
</html>
