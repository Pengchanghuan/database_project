<?php
session_start();
date_default_timezone_set("America/New_York");
$invitee = $_REQUEST["invitee"];
$wid = $_SESSION["wid"];
$uid = $_SESSION["uid"];

$connection = mysqli_connect("localhost", "username", "password", "snickr");

$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $invitee. '"';
$result1 = mysqli_query($connection,$query1);
if (mysqli_num_rows($result1) == 0) {
	echo "no one";
	return;
}
$row1 = mysqli_fetch_array($result1);
$inviteeuid = $row1["Uid"];

$query2 =
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $uid . ' AND WorkSpaceMember.Wrole = "Administrator"';
$result2 = mysqli_query($connection,$query2);
if (mysqli_num_rows($result2) == 0) {
	echo "no admin";
	return;
}

$query4=
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $inviteeuid;
$result4 = mysqli_query($connection,$query4);
if (mysqli_num_rows($result4) > 0) {
	echo "already in";
	return;
}

$query3 = 
'INSERT INTO WorkspaceInv (Wid, AdminID, Uid, WItime) VALUES 
(' . $wid . ', ' . $uid . ', ' . $inviteeuid . ', "' . date("Y-m-d H:i:s") . '")';
$result3 = mysqli_query($connection,$query3);

echo "success";
$connection->close();
?>