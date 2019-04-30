<?php
session_start();
date_default_timezone_set("America/New_York");
$invitee = $_REQUEST["invitee"];
$uid = $_SESSION["uid"];
$wid = $_SESSION["wid"];
$loginUsername = $_SESSION["loginUsername"];

$connection = mysqli_connect("localhost", "username", "password", "snickr");

$query1 = 'SELECT User.Uid AS Uid FROM User WHERE Uname = "' . $invitee. '"';
$result1 = mysqli_query($connection,$query1);
if (mysqli_num_rows($result1) == 0) {
	return;
}
$row1 = mysqli_fetch_array($result1);
$inviteeuid = $row1["Uid"];

$query2 =
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $uid . ' AND WorkSpaceMember.Wrole = "Administrator"';
$result2 = mysqli_query($connection,$query2);
if (mysqli_num_rows($result2) == 0) {
	return;
}

$query3=
'SELECT * FROM WorkSpaceMember
WHERE WorkSpaceMember.Wid = ' . $wid . ' AND WorkSpaceMember.Uid = ' . $inviteeuid;
$result3 = mysqli_query($connection,$query3);
if (mysqli_num_rows($result3) == 0) {
	return;
}

$query4 = 
'INSERT INTO Channel (Cname, Wid, Ctype, Ctime, Ccreator) VALUES 
("Direct with ' . $invitee . '", ' . $wid . ', "direct", "' . date("Y-m-d H:i:s") . '", ' . $uid  . ')';
$result4 = mysqli_query($connection,$query4);



$query45 = 
'SELECT Channel.Cid AS cid FROM Channel WHERE Channel.Cname = "Direct with ' . $invitee . '"';
$result45 = mysqli_query($connection,$query45);
if (mysqli_num_rows($result45) == 0) {
	return;
}
$row45 = mysqli_fetch_array($result45);
$cid = $row45["cid"];

$query5 =
'INSERT INTO ChannelMember (Cid, Uid, CMtime) VALUES 
(' . $cid . ', ' . $uid . ', "' . date("Y-m-d H:i:s") . '")';
$result5 = mysqli_query($connection,$query5);

$query6 =
'INSERT INTO ChannelMember (Cid, Uid, CMtime) VALUES 
(' . $cid . ', ' . $inviteeuid . ', "' . date("Y-m-d H:i:s") . '")';
$result6 = mysqli_query($connection,$query6);

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