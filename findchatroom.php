<?php

require 'dbconnect.php';
require 'functionFindRoom.php';

$inTwoMonths = 60 * 60 * 24 * 60 + time(); 

// process tags from form, save to cookies
for ($count = 1; $count <= 5; $count++){
	if (isset($_POST["tag$count"])){
		$tagContent = strtolower($_POST["tag$count"]);
		$tags[$count] = $tagContent;
	} else $tags[$count] = "";
}
$tagsString = implode('|', $tags);
setcookie("tags", $tagsString, $inTwoMonths);
$_COOKIE["tags"] = $tagsString; 

// get room
$roomID = findRoom();	// Later, write a function to return a room ID by using user's tags in cookies
$currentTime = time();

$userIdentifier = mt_rand(1,999);

$query = "SELECT * FROM users WHERE roomID=$roomID 
	AND identifier=$userIdentifier LIMIT 1";
$result = mysql_query($query) or die ('Error FindChatroom 27: '.mysql_error());
if ($row = mysql_fetch_array($result)){
	$userIdentifier = rand(1,999);
}
$userSalt = mt_rand(1,99999);

$query = "INSERT INTO users (roomID, identifier, salt, lastActivityTime) VALUES (
	$roomID,
	$userIdentifier,
	$userSalt,
	$currentTime)";
$result = mysql_query($query) or die('Error FindChatroom 15: '.mysql_error());

$userID = mysql_insert_id();

setcookie("roomID", $roomID, $inTwoMonths);
$_COOKIE["roomID"] = $roomID;
setcookie("userID", $userID, $inTwoMonths);
$_COOKIE["userID"] = $userID;
setcookie("userSalt", $userSalt, $inTwoMonths);
$_COOKIE["userSalt"] = $userSalt;

// check for duplicate dbtags
$tags = array_unique($tags);

// create dbtags for selected room
for ($count = 1; $count <= 5; $count++){
	if (isset($tags[$count]) && $tags[$count] != ""){
		$tagContent = $tags[$count];
		$tagContent = mysql_real_escape_string($tagContent);
		
		$query = "SELECT * FROM tags WHERE roomID=$roomID 
			AND content=\"$tagContent\" LIMIT 1";
		$result = mysql_query($query) or die ('Error FindChatroom 58: '.mysql_error());
		if ($row = mysql_fetch_array($result)){
			$tagID = $row['id'];
			$result = mysql_query("UPDATE tags SET quantity=quantity+1 WHERE id=$tagID") 
			or die ('Error FindChatroom 62: '.mysql_error());
		} else {
			$query = "INSERT INTO tags (roomID, content, quantity) VALUES (
				$roomID,
				\"$tagContent\",
				1)";
			$result = mysql_query($query) or die('Error FindChatroom 68: '.mysql_error());
			$tagID = mysql_insert_id();
		}
		
		$query = "INSERT INTO taguserlinks (tagID, userID) VALUES (
			$tagID,
			$userID)";
		$result = mysql_query($query) or die('Error FindChatroom 78: '.mysql_error());
	}
}

header ("Location: chat.php?room=$roomID");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Chat</title>
    
    <link rel="stylesheet" href="style.css" type="text/css" />

</head>

<body>

    <p><?php echo "$tagsString"; ?></p>

</body>

</html>