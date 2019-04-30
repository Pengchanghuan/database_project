<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$uid = $_SESSION["uid"];

$query = 
'SELECT WorkspaceInv.Wid AS Wid, WorkSpace.Wname AS Wname
FROM WorkspaceInv NATURAL JOIN WorkSpace
WHERE WorkspaceInv.Uid = ' . $uid . ' AND DATE_ADD(WorkspaceInv.WItime, interval 7 day) >= date(current_timestamp())';

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Wid":"'  . $row["Wid"] . '",';
    $outp .= '"Wname":"'. $row["Wname"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
?>