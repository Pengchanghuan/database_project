<?php

function authenticateUser($connection, $username, $password)
{
  // Test the username and password parameters
  if (!isset($username) || !isset($password))
    return false;
  if (strlen($username) == 0 || strlen($password) == 0) {
    return false;
  }
  // Formulate the SQL find the user
  $query = "SELECT * FROM User WHERE Uname = '{$username}'
            AND Upassword = '{$password}'";

  // Execute the query
  if (!$result = $connection->query($query))
    showerror();

  // exactly one row? then we have found the user
  if ($result->num_rows != 1) {
    return false;
  }
  else {
    return true;
  }
}

// Connects to a session and checks that the user has
// authenticated and that the remote IP address matches
// the address used to create the session.
function sessionAuthenticate()
{
  // Check if the user hasn't logged in
  if (!isset($_SESSION["loginUsername"]))
  {
    // The request does not identify a session
    $_SESSION["message"] = "You are not authorized to access the URL 
                            {$_SERVER["REQUEST_URI"]}";

    header("Location: logout.php");
    exit;
  }

  // Check if the request is from a different IP address to previously
  if (!isset($_SESSION["loginIP"]) || 
     ($_SESSION["loginIP"] != $_SERVER["REMOTE_ADDR"]))
  {
    // The request did not originate from the machine
    // that was used to create the session.
    // THIS IS POSSIBLY A SESSION HIJACK ATTEMPT

    $_SESSION["message"] = "You are not authorized to access the URL 
                            {$_SERVER["REQUEST_URI"]} from the address 
                            {$_SERVER["REMOTE_ADDR"]}";

    header("Location: logout.php");
    exit;
  }
}
function checkChongFu($connection, $username) {
  $query1 = "SELECT Uname FROM User WHERE Uname = '{$username}'";
  if (!$result1 = $connection->query($query1)) {
    return false;
  }
  if ($result1->num_rows == 0) {
    return true;
  } else {
    return false;
  }
}

function createNewAccount($connection, $username, $password, $nickname, $email) {
  $query2 = "INSERT INTO User (Uname, Uemail, Upassword, Unickname) VALUES
            ('{$username}', '{$email}', '{$password}', '{$nickname}')";
  if (!$result2 = $connection->query($query2)) {
    return false;
  } else {
    return true;
  }
}

function mysqlclean($array, $index, $maxlength, $connection) {
     if (isset($array["{$index}"]))
     {
        $input = substr($array["{$index}"], 0, $maxlength);
        //$input = mysql_real_escape_string($input, $connection);
        return ($input);
     }
     return NULL;
   }
?>
