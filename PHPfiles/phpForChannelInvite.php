<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$uid = $_SESSION["uid"];

$query = 
'SELECT ChannelInv.Cid AS Cid, Channel.Cname AS Cname
FROM ChannelInv NATURAL JOIN Channel
WHERE ChannelInv.Uid = ' . $uid . ' AND DATE_ADD(ChannelInv.CItime, interval 7 day) >= date(current_timestamp())';

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Cid":"'  . $row["Cid"] . '",';
    $outp .= '"Cname":"'. $row["Cname"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
?>