<?php
session_start();
date_default_timezone_set("America/New_York");
$message = $_REQUEST["message"];
$loginUsername = $_SESSION["loginUsername"];
$cid = $_SESSION["cid"];

$connection = mysqli_connect("localhost", "username", "password", "snickr");

$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $loginUsername. '"';
$result1 = mysqli_query($connection,$query1);
$row1 = mysqli_fetch_array($result1);
$uid = $row1["Uid"];

$query2 =
'INSERT INTO Message (Cid, Uid, Mtime, Mcontent) VALUES
(' . $cid . ', ' . $uid .', "' . date("Y-m-d H:i:s") . '", "' . $message . '")';
$result2 = mysqli_query($connection,$query2);

$query = 
'SELECT User.Uname AS Uname, Message.Mcontent AS Mcontent
FROM User NATURAL JOIN Message
WHERE Message.Cid = "' . $cid . '"
ORDER BY Message.Mtime';

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Uname":"'  . $row["Uname"] . '",';
    $outp .= '"Mcontent":"'. $row["Mcontent"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
?>