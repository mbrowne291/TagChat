<?php

require 'dbconnect.php';

$tagsString = $_COOKIE["tags"];
$tags = explode('|', $tagsString);

$roomID = (int)$_GET['room'];
$roomIsSet = false;

$roomTags = array();
$roomTagQuantity = array();

if ($roomID >= 1) {
	$query = "SELECT * FROM rooms WHERE id=$roomID LIMIT 1";
	$result = mysql_query($query) or die ('Error Chat 9: '.mysql_error());
	if ($row = mysql_fetch_array($result)){
		$roomIsSet = true;
		$query = "SELECT * FROM tags WHERE roomID=$roomID ORDER BY quantity DESC, id DESC LIMIT 5";
		$result = mysql_query($query) or die ('Error Chat 14: '.mysql_error());
		$index = 0;
		while ($row = mysql_fetch_array($result)){
			$roomTags[$index] = $row['content'];
			$roomTagQuantity[$index] = $row['quantity'];
			$index++;
		}
		
		$query = "SELECT * FROM users WHERE roomID=$roomID";
		$result = mysql_query($query) or die ('Error Chat 14: '.mysql_error());
		$roomUserQuantity = mysql_num_rows($result);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title>Chat</title>
    
    <link rel="stylesheet" href="style.css" type="text/css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
	
	<?php
	if ($roomIsSet == true){
		?>
		<script type="text/javascript">

		// ask user for name with popup prompt    
		var name;

		name = ""+<?php echo $_COOKIE['userID']?>;

		// kick off chat
		var chat =  new Chat();
		$(function() {	// code executed when document object model is ready

			// display name on page
			$("#name-area").html("You are: <span>" + name + "</span>");
			chat.getState(); 

			// watch textarea for key presses
			$("#sendie").keydown(function(event) {	// event returns key code

				var key = event.which;	// get key code

				//all keys including return.  
				if (key >= 33) {
					var maxLength = $(this).attr("maxlength");  
					var length = this.value.length;  

					// don't allow new content if length is maxed out
					if (length >= maxLength) {  
						event.preventDefault();  
					}
				}
			});
			// watch textarea for release of key press
			$('#sendie').keyup(function(e) {
				if (e.keyCode == 13) {
					var text = $(this).val();
					var maxLength = $(this).attr("maxlength");  
					var length = text.length; 

					// send 
					if (length <= maxLength + 1) {
						chat.send(text, name);
						$(this).val("");
					} else {
						$(this).val(text.substring(0, maxLength));
					}
				}
			});

		});
		
		chat.update();
		</script>
		
		<?php
	}
	?>

</head>

<body onload="setInterval('chat.update()', 1000)">

    <div id="page-wrap">
    
        <h1><a href="index.php">TagChat</a></h1>
		
		<?php
		if ($roomIsSet == true){
			?>
			
			<div id="chat-area"></div>
			<span id="name-area"></span>
			<form id="send-message-area">
				<p id="message-prefix">Your message: </p>
				<textarea id="sendie" maxlength = '100' ></textarea>
			</form>
			<span id="tags-area">Your tags are: <?php 
				$commaExpected = false;
				for ($count = 0; $count < 5; $count++){
					if (isset($tags[$count]) && $tags[$count] != ""){
						if ($commaExpected == true){
							echo ", ";
						}
						echo $tags[$count];
						$commaExpected = true;
					}
				}
				echo "<br />Most Popular tags: ";
				$commaExpected = false;
				for ($count = 0; $count < 5; $count++){
					if (isset($roomTags[$count]) && $roomTags[$count] != ""){
						if ($commaExpected == true){
							echo ", ";
						}
						echo $roomTags[$count] ." (".$roomTagQuantity[$count].")";
						$commaExpected = true;
					}
				}
				echo "<br />Number of users: ".$roomUserQuantity;
			?></span>
			
		<?php
		} else echo "No room selected.";
		?>
    </div>

</body>

</html>