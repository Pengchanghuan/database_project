<?php
session_start();
$connection = mysqli_connect("localhost", "username", "password", "snickr");
$cid = $_REQUEST["channelid"];
$uid = $_SESSION["uid"];

$query1=
'SELECT * FROM ChannelMember
WHERE ChannelMember.Cid = ' . $cid. ' AND ChannelMember.Uid = ' . $uid;
$result1 = mysqli_query($connection,$query1);
if (mysqli_num_rows($result1) > 0) {
	echo "already in channel";
	return;
}

$query2=
'insert into ChannelMember (Cid, Uid, CMtime) values 
(' . $cid . ', ' . $uid . ' , "' . date("Y-m-d H:i:s") . '")';
$result2 = mysqli_query($connection,$query2);

echo "accepted channel successful";
?>