<?php
if (isset($_COOKIE['tags'])){
	$tagsString = $_COOKIE["tags"];
	$tags = explode('|', $tagsString);
} else $tags = null;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>TagChat</title>
	<style type="text/css">
	body                            { font: 12px "Lucida Grande", Sans-Serif; background-color:rgb(65,48,37); }
	h1                             { color: rgb(153,217,234); font: 30px Helvetica, Sans-Serif; margin: 0 0 10px 0; }
	h1 a:link				{color: rgb(153,217,234); text-decoration:none;	}
	h1 a:visited				{color: rgb(153,217,234); text-decoration:none;	}
	h1 a:hover				{color: rgb(153,217,234); text-decoration:none;	}
	h1 a:active				{color: rgb(153,217,234); text-decoration:none;	}
	#page-wrap                      { width: 500px; margin: 30px auto; position: relative; }
	p.whiteText                        { color: white; }
	</style>
</head>
<body>
	<div id="page-wrap">
	<h1><a href="index.php">TagChat</a></h1>
	<p class="whiteText">Welcome to TagChat! TagChat is an anonymous chatroom service that matches you with other people with similar tags. To get started, 
	first choose your tags by putting in some of your interests.</p>
	<form action="findchatroom.php" method="post">
		<p class="whiteText">Choose your Tags:</p>
		<?php
		for ($count = 1; $count <= 5; $count++){
			echo "<input type=\"text\" name=\"tag$count\"";
			if (isset($tags[$count-1])) echo "value=\"".$tags[$count-1]."\"";
			echo "/><br />";
		}
		?><br />
		<input type="submit" id="submit" value="Find a Room"/>
	</form>
	</div>
</body>
</html>