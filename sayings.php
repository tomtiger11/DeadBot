<?php
switch ($entirecommandraw) {
	
	case 'What are you doing?':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I just sit here all day responding to you guys while being prodded by my master, Dead-i.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I know it gets boring after a while, but I'm kinda forced to unless I feel like throwing an error.\n");
		break;
		
}