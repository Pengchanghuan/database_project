<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$cid = $_REQUEST["cid"];
$_SESSION["cid"] = $cid;

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