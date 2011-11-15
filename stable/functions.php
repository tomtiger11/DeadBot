<?php

########################################
## DeadBot IRC Bot Configuration File ##
##### Important core bot functions #####
########################################

require 'config.php';

function raw($message) {
	global $socket;
	fputs($socket, $message."\n");
}

function sync() {
	$adminfile = file_get_contents('./admins.txt');
	$hostmasks = file_get_contents('./hostmasks.txt');
	global $adminfile;
	global $hostmasks;
}

function detectrecipient() {
	global $ex;
	$direct = strtolower(str_replace(array(chr(10), chr(13)), '', $ex[3]));
	return substr($direct, 1);
}