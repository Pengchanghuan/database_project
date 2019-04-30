<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$loginUsername = $_SESSION["loginUsername"];
$workspace = $_REQUEST["workspace"];

$query3 = 
'SELECT WorkSpace.Wid AS Wid FROM WorkSpace WHERE WorkSpace.Wname = "' . $workspace. '"';
$result3 = mysqli_query($connection,$query3);
$row3 = mysqli_fetch_array($result3);
$wid = $row3["Wid"];

$_SESSION["wid"] = $wid;

$query = 
'SELECT DISTINCT Channel.Cname AS Cname, Channel.Cid AS Cid
FROM User NATURAL JOIN ChannelMember NATURAL JOIN Channel NATURAL JOIN WorkSpace
WHERE (User.Uname = "' . $loginUsername . '" OR Channel.Ctype = "public") AND WorkSpace.Wid = ' . $wid;

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Channel":"'  . $row["Cname"] . '",';
    $outp .= '"Cid":"'. $row["Cid"] . '"}';
}
$outp ='{"records":['.$outp.']}';

echo($outp);
$connection->close();
?>