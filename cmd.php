<?php
switch ($command) {

	case 'help':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the valid commands that can be performed on me. Start all commands with 'deadbot'.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": about, status, calc, random, date, password, welcome, gsearch, gresult, translate\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": For additional help please visit my GitHub page. For admin commands use 'deadbot adminhelp.\n");
		break;
		
	case 'adminhelp':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the valid commands accessible by administrators only.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": trust (n), addadmin (n), viewadmins (n), deleteadmin (n), shutdown (n), restart (n), sync (n), echo (pm), raw (pm)\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": (n) = Can be run from within channel or private message. (pm) = Must be run through private message.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'op':
	case 'deop':
	case 'halfop':
	case 'dehalfop':
	case 'voice':
	case 'devoice':
	case 'kick':
	case 'ban':
		if ($admin == 1) {
			if ($value == '') $value = substr($userinfo[0], 1);
			fputs($socket, "CS ".$command." ".$ex[2]." ".$value."\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		$channel = $ex[2];
		break;
		
	case 'status':
		$timeonline = time() - $startseconds;
		$days = $timeonline / 86400;
		$timeonline = $timeonline % 86400;
		$hour = $timeonline / 3600;
		$timeonline = $timeonline % 3600;
		$mins = $timeonline / 60;
		$timeonline = $timeonline % 60;
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I have been connected for: ".round($days)." days, ".round($hour)." hours, ".round($mins)." minutes and ".round($timeonline)." seconds.\n");
		break;
			
	case 'about':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": My name is DeadBot, and I am currently under development by Dead-i.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": You can control me by starting commands with 'deadbot'. For example, 'deadbot about'.\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Find out more, report issues, and view my source: https://github.com/Dead-i/DeadBot\n");
		break;
		
	case 'random':
		if ($value == '') $value = 1;
		if ($value2 == '') $value2 = 1000;
		$valueexploderand = explode($value[0], '1234567890');
		$value2exploderand = explode($value2[0], '1234567890');
		if((isset($valueexploderand[1]) && isset($value2exploderand[1])) || ($value == 1 && $value2 == 1000)) {
			if ($value == '') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number: ".rand(0, 1000)."\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Randomly chosen number between ".$value." and ".$value2.": ".rand($value, $value2)."\n");
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the random command will only permit integers. You entered ".$value." and ".$value2.". Please use the password command for mixed outputs.\n");
		}
		break;
		
	case 'date':
		$valueexplode = explode('.', $value);
		if (isset($valueexplode[1])) fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": I am only able to process whole timezones; I cannot process +/- or fractions. For example, GMT would work, but GMT+4 or GMT+4.5 would not.\n");
		if ($value != NULL) date_default_timezone_set($value);
		if ($value == NULL) date_default_timezone_set('Europe/London');
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": In the timezone specified, it is now ".date('l jS F h:i:s a')." (".date_default_timezone_get().").\n");
		break;
		
	case 'password':
		if ($value == '') $value = '7';
		$valueexploderand = explode($value[0], '1234567890');
		$symbolexploderand = explode('sym', $data);
		$integerexploderand = explode('int', $data);
		if(isset($valueexploderand[1])) {
			$value = (int)$value;
			if (isset($symbolexploderand[1])) {
				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!�$%^&*()';
				$length = 60;
			}else{
				$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$length = 51;
			}
			
			if (isset($integerexploderand[1])) {
				$string = $string.'123456789';
				$length = $length + 9;
			}
			
			if ($value < 24) {
				$count = 0;
				while ($count < $value) {
					$random = rand(0, $length);
					$passwordgen = $passwordgen.$string[$random];
					$count = $count + 1;
				}
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The requested password has been private messaged to you.\n");
				fputs($socket, "PRIVMSG ".substr($recipient, 1)." :Randomly chosen pasword in which is ".$value." characters long: ".$passwordgen."\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The requested password is too long. Please shorten it.\n");
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Sorry, the password command will only permit positive integers as lengths. You requested a password that is '".$value."' long.\n");
		}
		$passwordgen = '';
		break;
		
	case 'welcome':
		date_default_timezone_set('Europe/London');
		$languageid = rand(1, 12);
		
		switch ($languageid) {
			
			case '1':
				$lang = 'English';
				$welcome = 'Hello';
				break;
				
			case '2':
				$lang = 'French';
				$welcome = 'Bonjour';
				break;
				
			case '3':
				$lang = 'Spanish';
				$welcome = '�Hola';
				break;
				
			case '4':
				$lang = 'German';
				$welcome = 'Guten tag';
				break;
				
			case '5':
				$lang = 'Italian';
				$welcome = 'Ciao';
				break;
				
			case '6':
				$lang = 'Irish';
				$welcome = 'Dia duit';
				break;
				
			case '7':
				$lang = 'Welsh';
				$welcome = 'Helo';
				break;
				
			case '8':
				$lang = 'Dutch';
				$welcome = 'Hallo';
				break;
				
			case '9':
				$lang = 'Portuguese';
				$welcome = 'Ola';
				break;
				
			case '10':
				$lang = 'Swedish';
				$welcome = 'Halla';
				break;
				
			case '11':
				$lang = 'Polish';
				$welcome = 'Czesc';
				break;
				
			case '12':
				$lang = 'Icelandic';
				$welcome = 'Hallo';
				break;
				
		}
		
		if ($admin == 1) $welcomeadmin = ' You are an administrator of DeadBot.';
		
		$welcomehost = explode('!', $data);
		$welcomehost = explode(' ', $welcomehost[1]);
		$welcomehost = $welcomehost[0];
		
		fputs($socket, "PRIVMSG ".$ex[2]." :".$welcome.", ".substr($recipient, 1)."! Right now it is ".date('l jS F h:i:s a')." in ".date_default_timezone_get().". Your full name and host mask is ".$welcomehost.".".$welcomeadmin."\n");
		fputs($socket, "PRIVMSG ".$ex[2]." :And guess what? You just learned how to say hello in ".$lang."! For help here, type 'Bubba help'. To control me, please use 'DeadBot help'.\n");
		break;
		
	case 'gsearch':
		$term = explode('gsearch ', $data);
		$term = $term[1];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://www.google.co.uk/search?q=".substr(urlencode($term), 0, -6)."\n");
		break;
		
	case 'gresult':
		$term = explode('gresult ', $data);
		$term = $term[1];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://www.google.co.uk/search?q=".substr(urlencode($term), 0, -6)."&btnI=1\n");
		break;
	
	case 'translate':
		$value2 = explode($value.' ', $data);
		$value2 = explode(' ', $value2[1]);
		$value2 = $value2[0];
		$value3 = explode($value2.' ', $data);
		$value3 = explode(' @', $value3[1]);
		$value3 = $value3[0];
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": http://translate.google.co.uk/#".$value."|".$value2."|".urlencode($value3)."\n");
		break;
		
	case 'addadmin':
		if ($admin == 1) {
			$fp = fopen('admins.txt', "w");
			fwrite($fp, substr($adminfile, 0, -1).$value.',');
			fclose($fp);
			$adminfile = file_get_contents('./admins.txt');
			$hostmasks = file_get_contents('./hostmasks.txt');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been successfully added to the admin log.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": You have been given administrative privledges. Do not abuse it or your privledges will be removed.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'viewadmins':
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Here are the current administrators of DeadBot:\n");
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".str_replace(',', ', ', $adminfile)."\n");
		break;
		
	case 'deleteadmin':
		if ($admin == 1) {
			$fp = fopen('admins.txt', "w");
			fwrite($fp, str_replace($value.',', '', $adminfile));
			fclose($fp);
			$adminfile = file_get_contents('./admins.txt');
			$hostmasks = file_get_contents('./hostmasks.txt');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The user '".$value."' has been deleted from the admin log.\n");
			fputs($socket, "PRIVMSG ".$ex[2]." ".$value.": If you did something bad, shame on you! :P\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'trust':
		if (isset($adminarray[1]) && $value == $staffpass) {
			$fp = fopen('hostmasks.txt', "w");
			fwrite($fp, $hostmasks.$hostmask.',');
			fclose($fp);
			$adminfile = file_get_contents('./admins.txt');
			$hostmasks = file_get_contents('./hostmasks.txt');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Your hostmask will now be trusted. You have been identified as an administrator.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'sync':
		if ($admin == 1) {
			$adminfile = file_get_contents('./admins.txt');
			$hostmasks = file_get_contents('./hostmasks.txt');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Admin levels synchronized.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'shutdown':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." :Goodbye!\n");
			fputs($socket, "QUIT :Requested by administrator\n");
			die;
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'restart':
		if ($admin == 1) {
			fputs($socket, "PRIVMSG ".$ex[2]." :I will now attempt to restart myself.\n");
			fputs($socket, "QUIT :Restarting as requested by administrator\n");
			shell_exec('screen php /home/kloxo/httpd/default/irc/index.php');
			sleep(2);
			die;
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'debug':
		if ($admin == 1) {
			if ($argv[1] == 'debug') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to OFF\n");
				fputs($socket, "QUIT :Requested by administrator\n");
				shell_exec('screen php /home/kloxo/httpd/default/irc/index.php');
				sleep(2);
				die;
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Switching debug mode to ON\n");
				fputs($socket, "QUIT :Requested by administrator\n");
				shell_exec('screen php /home/kloxo/httpd/default/irc/index.php debug');
				sleep(2);
				die;
			}
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'update':
		if ($admin == 1) {
			echo shell_exec('cd /home/kloxo/httpd/default/irc/; /usr/local/bin/git pull');
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Synchronized with GitHub. A restart is recommended if the core file was modified.\n");
		}else{
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Only the DeadBot administrators have the ability to run that command. Please ask him if you would like this command to be run.\n");
		}
		break;
		
	case 'calc':
		$calculate = explode('calc ', $data);
		$calculate = $calculate[1];
		$calculate = trim($calculate);
		
		$calculate = preg_replace ('[^0-9\+-\*\/\(\) ]', '', $calculate);
		$letters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		$calculate = str_replace($letters, '', $calculate);
		
		$calculateexplode = explode('/0', $calculate);
		$calculateexplode2 = explode('/ 0', $calculate);
		if (isset($calculateexplode[1]) || isset($calculateexplode2[1])) {
			$calculateinfo = "(undefined)";
		}else{
			$calculateinfo = "";
		}
		
		eval("\$calculate = $calculate;");
		
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$calculate.$calculateinfo."\n");
		break;
		
	case 'issues':
		
		$servers = 'stoli,boru,starka,chopin,lotus,';
		$serverdetect = explode($value.',', $servers);
		
		if ($value != '' && isset($serverdetect[1])) {
			
			$value[0] = strtoupper($value[0]);
			
			if (file_get_contents($external.'?server='.$value.'&type=server') == 'online') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." HTTP is currently online.\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." HTTP is currently offline.\n");
			}
			
			if (substr(file_get_contents($external.'?server='.$value.'&type=mysql'), 0, -1) == 'online') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." MySQL is currently online.\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." MySQL is currently offline.\n");
			}
			
			if (file_get_contents($external.'?server='.$value.'&type=ftp') == 'online') {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." FTP is currently online.\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$value." FTP is currently offline.\n");
			}
		
		}else{
			
			fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": Diagnosing servers, please be patient. Although accurancy of the results cannot be guarenteed, this command is fairly accurate.\n");
			
			$servers = array('stoli', 'boru', 'starka', 'chopin', 'lotus');
			foreach ($servers as $server) {
				if (file_get_contents($external.'?server='.$server.'&type=server') != 'online') {
					$serveroutput .= $server.' is currently offline. ';
				}
				
				if (substr(file_get_contents($external.'?server='.$server.'&type=mysql'), 0, -1) != 'online') {
					$serveroutput .= $server.' MySQL is currently offline. ';
				}
				
				if (file_get_contents($external.'?server='.$server.'&type=ftp') != 'online') {
					$serveroutput .= $server.' FTP is currently offline. ';
				}
			}
		
			if (isset($serveroutput)) {
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": ".$serveroutput."\n");
			}else{
				fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": All servers are online.\n");
			}
			
			unset($serveroutput);
		
		}
		
		break;
		
	default:
		fputs($socket, "PRIVMSG ".$ex[2]." ".$recipient.": The command you specified was not found. Please type 'deadbot help' if you would like to a see a list of valid commands.\n");
		break;
		
}