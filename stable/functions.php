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