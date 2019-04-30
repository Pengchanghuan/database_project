<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$wid = $_REQUEST["workspaceid"];
$uid = $_SESSION["uid"];

$query1=
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid. ' AND WorkSpaceMember.Uid = ' . $uid;
$result1 = mysqli_query($connection,$query1);
if (mysqli_num_rows($result1) > 0) {
	echo "already in workspace";
	return;
}

$query2=
'INSERT INTO WorkSpaceMember (Wid, Uid, WMtime, Wrole) VALUE 
(' . $wid . ', ' . $uid . ', "' . date("Y-m-d H:i:s") . '", "Member")';
$result2 = mysqli_query($connection,$query2);

echo "accepted workspace successful";
?>