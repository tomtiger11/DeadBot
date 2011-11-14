<?php

########################################
## DeadBot IRC Bot Configuration File ##
##### Important core bot functions #####
########################################

require 'config.php';

function raw($message) {
	fputs($socket, $message."\n");
}

function sync() {
	$adminfile = file_get_contents('./admins.txt');
	$hostmasks = file_get_contents('./hostmasks.txt');
}

function startup() {
	require 'config.php';
	set_time_limit(0);
	$startseconds = time();
	$current = date('ymdHis');
	$socket = fsockopen($network, 6667);
	raw("USER ".$nick." ".$name." CM :".$nick);
	raw("NICK ".$nick);
	raw("JOIN ".$channel1);
	raw("JOIN ".$channel2);
	sync();
	echo "Bot Started";
}