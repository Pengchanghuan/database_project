<?php
session_start();
date_default_timezone_set("America/New_York");
$invitee = $_REQUEST["invitee"];
$cid = $_SESSION["cid"];
$uid = $_SESSION["uid"];
$wid = $_SESSION["wid"];


$connection = mysqli_connect("localhost", "username", "password", "snickr");

$query0=
'SELECT * FROM Channel
WHERE Channel.Cid = ' . $cid . ' AND Channel.Ctype="direct"';
$result0 = mysqli_query($connection,$query0);
if (mysqli_num_rows($result0) > 0) {
	echo "diret";
	return;
}

$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $invitee. '"';
$result1 = mysqli_query($connection,$query1);
if (mysqli_num_rows($result1) == 0) {
	echo "no one";
	return;
}
$row1 = mysqli_fetch_array($result1);
$inviteeuid = $row1["Uid"];

$query2=
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $inviteeuid;
$result2 = mysqli_query($connection,$query2);
if (mysqli_num_rows($result2) == 0) {
	echo "not in workspace";
	return;
}

$query4=
'SELECT * FROM ChannelMember
WHERE ChannelMember.Cid = ' . $cid . ' AND ChannelMember.Uid = ' . $inviteeuid;
$result4 = mysqli_query($connection,$query4);
if (mysqli_num_rows($result4) > 0) {
	echo "already in channel";
	return;
}

$query3 = 
'INSERT INTO ChannelInv (Cid, CreatorID, Uid, CItime) VALUES 
(' . $cid . ', ' . $uid . ', ' . $inviteeuid . ', "' . date("Y-m-d H:i:s") . '")';
$result3 = mysqli_query($connection,$query3);

echo "success";
$connection->close();
?>