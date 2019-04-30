<?php
session_start();
date_default_timezone_set("America/New_York");
$newWorkspace = $_REQUEST["newWorkspace"];

$connection = mysqli_connect("localhost", "username", "password", "snickr");
$loginUsername = $_SESSION["loginUsername"];

$query0 = 'SELECT WorkSpace.Wname AS Wid FROM WorkSpace WHERE WorkSpace.Wname = "' . $newWorkspace. '"';
$result0 = mysqli_query($connection,$query0);
if (mysqli_num_rows($result0) > 0) {
	return;
}

/*$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $loginUsername. '"';
$result1 = mysqli_query($connection,$query1);
$row1 = mysqli_fetch_array($result1);
$uid = $row1["Uid"];*/

$uid = $_SESSION["uid"];

$query2 = 
'INSERT INTO WorkSpace (Wname, Wdescription, Wtime, Wcreator) VALUES
("' . $newWorkspace . '", "WTF", "' . date("Y-m-d H:i:s") . '", ' . $uid . ')';

$result2 = mysqli_query($connection,$query2);

$query3 = 
'SELECT WorkSpace.Wid AS Wid FROM WorkSpace WHERE WorkSpace.Wname = "' . $newWorkspace. '"';
$result3 = mysqli_query($connection,$query3);
$row3 = mysqli_fetch_array($result3);
$wid = $row3["Wid"];

$query4 = 
'INSERT INTO WorkspaceMember (Wid, Uid, WMtime, Wrole) VALUES 
(' . $wid . ', ' . $uid . ', "' . date("Y-m-d H:i:s") . '", "Administrator")';
$result4 = mysqli_query($connection,$query4);

$query = 
'SELECT DISTINCT Workspace.Wname AS Wname FROM 
User NATURAL JOIN WorkspaceMember NATURAL JOIN Workspace
WHERE User.Uname = "' . $loginUsername . '"';

$result = mysqli_query($connection,$query);

$outp = "";
while($row = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"Workspace":"'  . $row["Wname"] . '"}';
}
$outp ='{"records":['.$outp.']}';
$connection->close();

echo($outp);
$connection->close();
?>