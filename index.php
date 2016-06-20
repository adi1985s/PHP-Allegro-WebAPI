<?php

session_start();

?>

<html lang="pl"
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<link rel="stylesheet" href="css/bootstrap.css"  type="text/css" />
	<link rel="stylesheet" href="css/form-style.css" type="text/css" />
</head>
	<body>


		<div class="container">


      	 <form class="form-signin" action="login.php" method ="post">
       		<h2 class="form-signin-heading">PHP Allegro WebAPI Interface</h2>
       		
      		<input name="user_login"	type="text" 	id="user_login" 	placeholder="Login" 	class="form-control" required	autofocus>
			<input name="user_password" type="password" id="user_password"  placeholder="Password"  class="form-control" required>
			<input name="user_key"		type="text"		id="user_key"		placeholder="Key"		class="form-control" required>
	
		<div class="checkbox">
          <label>
            <input type="checkbox" name ="sandbox_check"> Zaloguj do sandboxa.
          </label>
        </div>
      
     
        <button class="btn btn-lg btn-warning btn-block" type="submit">Zaloguj</button>
      </form>
      
<?php
if(isset($_SESSION['error']))
	echo $_SESSION['error'];
	session_unset();
?>


    </div> <!-- /container -->
		
		
		
		
    <script type="text/javascript" src="js/script.js"></script>
	</body>
</html>