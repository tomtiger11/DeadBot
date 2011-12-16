<?php

#########################
##DeadBot v1.0 Stable ##
###An IRC Bot in PHP ###
#### Functions File #####
#########################

// Send raw message function
function raw($command) {
	global $socket;
	fputs($socket, $command."\n");
	echo "::: Command Sent - ".trim($command)." ::: \n\n";
}

// Send normal message with recipient function
function send($command) {
	global $socket;
	global $recipient;
	global $ex;
	fputs($socket, "PRIVMSG {$ex[2]} :{$recipient}: {$command}\n");
	echo "::: Message Sent to {$recipient} in {$ex[2]} - ".trim($command)." ::: \n\n";
}

// Send normal message without recipient function
function normal($command, $sendchannel) {
	global $socket;
	fputs($socket, "PRIVMSG {$sendchannel} :{$command}\n");
	echo "::: Message Sent in {$ex[2]} - ".trim($command)." ::: \n\n";
	
}

// A find function - useful in many cases
function find($delimiter, $string) {
	$string = $string.'.';
	$explode = explode($delimiter, $string);
	if (isset($explode[1])) {
		return 1;
	}else{
		return 0;
	}
	
}

// Get the content of the command
function content($string) {
	global $data;
	$string = $string.' ';
	$result = explode($string, $data);
	$result = trim($result[1]);
	return $result;
}