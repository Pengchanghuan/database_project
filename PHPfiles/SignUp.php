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

.error {color: #FF0000;}

</style>


</script>

<body>


<?php
$message = "";
$usernameErr = $emailErr = $passwordErr = $nicknameErr = $password_againErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  require 'authentication.inc';
  require 'db.inc';
  
  if (!$connection = new mysqli("localhost", "username", "password", "snickr"))
    die("Cannot connect");

  // Clean the data collected in the <form>
  $username = mysqlclean($_POST, "username", 20, $connection);
  $password = mysqlclean($_POST, "password", 20, $connection);
  $password_again = mysqlclean($_POST, "password_again", 20, $connection);

  $nickname = mysqlclean($_POST, "nickname", 20, $connection);
  $email = mysqlclean($_POST, "email", 20, $connection);

  if (empty($username)) {
    $usernameErr = "Name is required<br>";
  } else if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
    $nameErr = "Only letters and white space allowed<br>"; 
  } else if (!checkChongFu($connection, $username)){
    $usernameErr = "Has been used<br>";
  }

  if (empty($nickname)) {
    $nicknameErr = "Nickname is required<br>";
  } else {
    if (!preg_match("/^[a-zA-Z ]*$/",$nickname)) {
      $nicknameErr = "Only letters and white space allowed<br>"; 
    }
  }

  if (empty($email)) {
    $emailErr = "Email is required<br>";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format<br>"; 
    }
  }

  if (empty($password)) {
    $passwordErr = "Password is required<br>";
  } else {
    if (!preg_match("/^[0-9a-zA-Z ]*$/",$password)) {
      $passwordErr = "Only numbers, letters and white space allowed<br>"; 
    }
  }

  if (empty($password_again)) {
    $password_againErr = "Password again is required<br>";
  } else {
    if (!preg_match("/^[0-9a-zA-Z ]*$/",$password_again)) {
      $password_againErr = "Only numbers, letters and white space allowed<br>"; 
    }
  }

  if (strcmp($password, $password_again) != 0) {
    $passwordErr = $password_againErr = "Passwords are not the same";
  } 
  
  if (strlen($usernameErr) > 0 || strlen($nicknameErr) > 0 || 
    strlen($emailErr) > 0 || strlen($passwordErr) > 0 || strlen($password_againErr) > 0) {

  } else {
    if (createNewAccount($connection, $username, $password, $nickname, $email)) {
      $message = "Create successful";
    } else{
      $message = "Fail to create account";
    }
  }
  
}
?>

<div>
  <ul>
    <li><a href="LoginPage.php">Login</a></li>
    <li><a class="active" href="#">Signup</a></li>
  </ul>
  <form method="POST" action="SignUp.php">
    <label for="username">Username:</label><br>
    <input type="text" size = 20 id="username" name="username" placeholder="Your username" value="<?php echo $username;?>">
    <span class="error"><?php echo $usernameErr;?></span><br>

    <label for="nickname">Nickname:</label><br>
    <input type="text" size = 20 id="nickname" name="nickname" placeholder="Your nickname" value="<?php echo $nickname;?>">
    <span class="error"><?php echo $nicknameErr;?></span><br>

    <label for="email">Your email:</label><br>
    <input type="text" size = 20 id="email" name="email" placeholder="Your email" value="<?php echo $email;?>">
    <span class="error"><?php echo $emailErr;?></span><br>

    <label for="password">Password:</label><br>
    <input type="password" size = 20 id="password" name="password" placeholder="Your password" value="<?php echo $password;?>">
    <span class="error"><?php echo $passwordErr;?></span><br>

    <label for="password again">Password again:</label><br>
    <input type="password" size = 20 id="password again" name="password_again" placeholder="Your password again" value="<?php echo $password_again;?>">
    <span class="error"><?php echo $password_againErr;?></span><br>

    <br>
    <input type="submit" value="Signup">
  </form>
</div>

<?php
if (strlen($message) > 0) {
  echo "<script>alert('$message');</script>";
}
?>
</body>
</html>
