<?php
session_start();
date_default_timezone_set("America/New_York");
$newChannel = $_REQUEST["newChannel"];
$channelType = $_REQUEST["channelType"];
$loginUsername = $_SESSION["loginUsername"];
$wid = $_SESSION["wid"];

$connection = mysqli_connect("localhost", "username", "password", "snickr");

/*$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $loginUsername. '"';
$result1 = mysqli_query($connection,$query1);
$row1 = mysqli_fetch_array($result1);
$uid = $row1["Uid"];*/
$uid = $_SESSION["uid"];

$query2 =
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $uid . ' AND WorkSpaceMember.Wrole = "Administrator"';
$result2 = mysqli_query($connection,$query2);


$query25 = 
'SELECT Channel.Cid AS cid FROM Channel WHERE Channel.Cname = "' . $newChannel . '"';
$result25 = mysqli_query($connection,$query25);

if (mysqli_num_rows($result2) > 0 && mysqli_num_rows($result25) == 0 && ($channelType == "public" || $channelType == "private")) {
	$query3 = 
	'INSERT INTO Channel (Cname, Wid, Ctype, Ctime, Ccreator) VALUES 
	("' . $newChannel . '", ' . $wid . ', "' . $channelType . '", "' . date("Y-m-d H:i:s") . '", ' . $uid  . ')';
	$result3 = mysqli_query($connection,$query3);

	$query4 = 
	'SELECT Channel.Cid AS cid FROM Channel WHERE Channel.Cname = "' . $newChannel . '"';
	$result4 = mysqli_query($connection,$query4);
	$row4 = mysqli_fetch_array($result4);
	$cid = $row4["cid"];

	$query5 =
	'INSERT INTO ChannelMember (Cid, Uid, CMtime) VALUES 
	(' . $cid . ', ' . $uid . ', "' . date("Y-m-d H:i:s") . '")';
	$result5 = mysqli_query($connection,$query5);
}

$query = 
'SELECT Channel.Cname AS Cname, Channel.Cid AS Cid
FROM User NATURAL JOIN ChannelMember NATURAL JOIN Channel NATURAL JOIN WorkSpace
WHERE User.Uname = "' . $loginUsername . '" AND WorkSpace.Wid = ' . $wid;

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