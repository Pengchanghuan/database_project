<!DOCTYPE html>

<html>

<style>
input[type=text], input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width: 300px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

ul {
  list-style-type: none;
  margin: 0 0 10px 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  border-radius: 5px;
}

li {
  width: 50%;
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: lightblue;
}

.active {
  background-color: #4CAF50;
}

input[type="submit"] {
  font-size: 15px;
}

</style>

<body>


<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require 'authentication.inc';

  if (!$connection = new mysqli("localhost", "username", "password", "snickr"))
    die("Cannot connect");

  // Clean the data collected in the <form>
  $loginUsername = mysqlclean($_POST, "loginUsername", 20, $connection);
  $loginPassword = mysqlclean($_POST, "loginPassword", 20, $connection);
  
  session_start();
  $_SESSION["loginUsername"] = "$loginUsername";
  $_SESSION["loginPassword"] = "$loginPassword";

  $query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $loginUsername. '"';
  $result1 = mysqli_query($connection,$query1);
  $row1 = mysqli_fetch_array($result1);
  $uid = $row1["Uid"];
  $_SESSION["uid"] = $uid;

  // Authenticate the user
  if (authenticateUser($connection, $loginUsername, $loginPassword)) {
    header("Location: Liaotianshi.php");
  } else {
    $message = "Wrong account or password";
  }
}
?>



<div>
  <ul>
    <li><a class="active">Login</a></li>
    <li><a href="SignUp.php">Signup</a></li>
  </ul>
  <form method="POST" action="LoginPage.php">
    <label for="username">Username:</label><br>
    <input type="text" size = 20 id="username" name="loginUsername" placeholder="Your username"
    value="<?php echo $loginUsername;?>"><br>

    <label for="password">Password:</label><br>
    <input type="password" size = 20 id="password" name="loginPassword" placeholder="Your password"
    value="<?php echo $loginPassword;?>"><br>
  
    <a href="#" id="forget" style="font-size:10px;color:blue" onclick="alert('Try to remember!')">Forget your password?</a>
    <input type="submit" value="Login">
  </form>
</div>


<?php
if (strlen($message) > 0) {
  echo "<script>alert('$message');</script>";
}
?>
</body>
</html>
