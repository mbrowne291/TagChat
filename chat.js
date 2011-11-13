/* 
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instance = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(){
	if(!instance){
		instance = true;	// While AJAX request is out, don't send another one
		$.ajax({
			type: "POST",
			url: "process.php",
			data: {  
				'function': 'getState'	// The action that is sent to process
			},
			dataType: "json",
			
			success: function(data){
				state = data.state;	// Receives number of lines in server
				instance = false;
			},
		});
	}
}

//Updates the chat
// If there are new lines on the server, append them to the chat area
function updateChat(){
	if(!instance){
		instance = true;	// While AJAX request is out, don't send another one
		$.ajax({
			type: "POST",
			url: "process.php",
			data: {
				'function': 'update',	// What the user wants to do
				'state': state	// How many lines the user's text area has
			},
			dataType: "json",
			success: function(data){
				$('#chat-area').empty();
				if(data.text){	// Any new lines stored by the server are added
					for (var i = 0; i < data.text.length; i++) {
						$('#chat-area').prepend($("<p>"+ data.text[i] +"</p>"));
					}
				}
				document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				instance = false;
				state = data.state;
			},
		});
	}
	else {
		setTimeout(updateChat, 1500);	// in case of failure, keep checking
	}
}

//send the message
// Send message to the server, and update window afterwards
function sendChat(message, nickname)
{       
	//updateChat();
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {  
			'function': 'send',
			'message': message,
			'nickname': nickname,
			'file': file
		},
		dataType: "json",
		success: function(data){
			instance = false;
			updateChat();
		},
	});
}
