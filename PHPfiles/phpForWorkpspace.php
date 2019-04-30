<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$loginUsername = $_SESSION["loginUsername"];
$query = 
"SELECT DISTINCT Workspace.Wname AS Wname FROM 
User NATURAL JOIN WorkspaceMember NATURAL JOIN Workspace
WHERE User.Uname = '$loginUsername'";

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Workspace":"'  . $row["Wname"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
?>