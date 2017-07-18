<!DOCTYPE html>
<html>
<head>
	<title>Surplus QR code</title>
</head>
<body>

<?php
session_start();
	
	if($_POST['uname'] == "SurplusAdmin" && $_POST['psw'] =="SurplusAdmin"){

		echo "UserName : ".$_POST['uname']."<br/>";
		echo "Password : ".$_POST['psw'];

		$_SESSION["isloggedin"] = true;

		header( "Location: login.php");

	} else {
		echo "Enter valid username and passowrd!";
	}

?>
<form action="login.php" method="post">

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" value="SurplusAdmin" required> 
    <br/><br/><br/>
    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" value="SurplusAdmin" required>
    <br/><br/><br/>

    <button type="submit">Login</button>
  </div>

</form>


</body>
</html>