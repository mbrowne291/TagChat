<?php
	require 'dbconnect.php';

	$function = $_POST['function'];

	$log = array();

	switch($function) {
		
		case('getState'):
			if(file_exists('chat.txt')){
				$lines = file('chat.txt');
			}
			$log['state'] = count($lines); 
			break;
		
		case('update'):
			//$state = $_POST['state'];
			/*
			if(file_exists('chat.txt')){
				$lines = file('chat.txt');
			}
			$count = count($lines);
			if($state == $count){	// If line number passed in is equal, don't update
				$log['state'] = $state;
				$log['text'] = false;
			} else {
				$text= array();
				$log['state'] = $state + count($lines) - $state;
				foreach ($lines as $line_num => $line)
				{
					if($line_num >= $state){
						$text[] = $line = str_replace("\n", "", $line);
					}
				}
				$log['text'] = $text;
			}
			*/
			$roomID = 1;
			$timeCutoff = time() - (60*60);	// 1 hour ago
			$query = "SELECT * FROM messages WHERE 
				roomID=$roomID AND 
				timeCreated >= $timeCutoff 
				ORDER BY timeCreated DESC LIMIT 999";
			$result = mysql_query($query) or die ('Error Process 45: '.mysql_error());
			$text = array();
			while ($row = mysql_fetch_array($result)){
				$text[] = $row['content'];
			}
			$log['text'] = $text;
			break;
		
		case('send'):
			$nickname = htmlentities(strip_tags($_POST['nickname']));
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			$message = htmlentities(strip_tags($_POST['message']));
			if(($message) != "\n"){
				if(preg_match($reg_exUrl, $message, $url)) {
					$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				}
				/*
				fwrite(fopen('chat.txt', 'a'), $nickname . ": " . $message = str_replace("\n", " ", $message) . "\n");
				*/
				$message = $nickname . ": " . str_replace("\n", " ", $message);
				
				// Insert message, etc...
				$roomID = 1;
				$currentTime = time();
				
				$query = "INSERT INTO messages (roomID, content, timeCreated) VALUES (
					$roomID,
					\"$message\",
					$currentTime)";
				$result = mysql_query($query) or die('Error Process 56: '.mysql_error());
			}
			break;
	}
	echo json_encode($log);
?>