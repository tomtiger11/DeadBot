DeadBot is an IRC Bot which runs on PHP 5 and has many useful functions that
people on the IRC channel can use. DeadBot is active most of the time in
irc.x10hosting.com #publicchat and serves as an informational and
entertainment bot. DeadBot has the ability of recognizing bot administrators
and allows them to perform special commands on him. DeadBot also has the
ability for modification to his commands and sayings to take place without the
need of restarting.

##ÊCommands ##
Here are the valid commands that can be performed on DeadBot for a normal
user. All commands should start with the term 'deadbot' and can be sent
from either a channel DeadBot is joined in or via private message. Some
commands require values, which can be set after the command name. For example,
``deadbot calc 1+1``

**about**: This command will display basic information about DeadBot and a
link to the GitHub page.

**help**: This command will display a list of the valid commands that can be
performed on DeadBot.

**status**: This command will display the approximate number of days, hours,
minutes and seconds in which DeadBot has been started for. This will be reset
everytime DeadBot shuts down or is restarted.

**calc**: This command has the ability of calculating the required value and
returning the answer.

**random**: This command will return a random number between the first and
second value. If a first and second value was not specified, the first value
will automatically be set as 1 and the second will be set as 1000.

**date**: This command will display the current date and time in a specific
place or timezone. If a value is set, DeadBot will attempt to recognize the
value as a timezone and the result will change accordingly. If no value is
set, the default timezone (Europe/London) is set.

**password**: This command will create a randomly generated password. The
first value is the length of the password (the default is 7) and after the
first value one/both of these parameters can be set: inte (include numbers)
and symb (include symbols). The password will be sent via private message.

**welcome**: This command will display a welcome message to the designated
recipient. The message will contain the word 'hello' in a random language
followed by the users nick, indent, hostmask, channel information, and whether
the user is an administrator or not.

**gsearch**: This command will display a direct link to a google search page
displaying the search results of the required value.

**gresult**: This command will display a direct link to the top search result
of the requested value; also known as Google's "I'm feeling Lucky" service.

**translate**: This command will display a direct link to Google's Translation
service where the third value will be translated from the first value to the
second value. For example, ``deadbot translate en es Hello``

Did you know that you can direct commands at people other than yourself? To do
this, place the @ symbol at the end of your command followed by the designated
recipient. For example, ``deadbot about @ Dead-i``

## Administrative Commands ##
The administrators of DeadBot have the ability to run certain commands that
normal users cannot. DeadBot recognizes administrators via their nick and
their hostmask. All of the administrators are stored inside admins.txt and all
of the trusted hostmasks are stored inside hostmasks.txt.

**trust**: This is the essential command for all administators. If the admin's
hostmask is not in the log, then an admin can request for DeadBot to add it.
If the nick matches one that is in the admin.txt file, then the trust command
will add the admin's hostmask to the log as long as the correct password is
provided. The value of the trust command MUST be the matching staffpass stated
in the config file to enable DeadBot to trust the admin.

**viewadmins**: This command will display a list of administrators in the
admin log.

**addadmin**: This command will insert the value (nick) into the admin log.
Please note that after the admin has been added the new admin will need to run
the trust command in order to receive administrative priviledges.

**deletadmin**: This command will delete the value (nick) from the admin log.

**shutdown**: This command will instruct DeadBot to shut itself down.

**restart**: This command will instruct DeadBot to attempt to shut itself down
and then start up again five seconds later.

**debug**: This command will instruct DeadBot to restart itself into debug
mode. When DeadBot is in debug mode, all of the chat conversations will appear
at the server. To turn debug mode off, just run the same command again.

**update**: This command will attempt to pull the latest copy of DeadBot from
GitHub.

**echo**: This command can only be run via private message and it will display
the value in the channel.

**raw**: This command can only be run via private message and will instruct
DeadBot to send a completely raw command (value).

## License ##
If you want to use my software, then feel free to do whatever you want with
it. However, please keep the GitHub link on the about page if you do use it -
consider it as a "thank you".

## Install ##
If you would like to install DeadBot on your own server for your own channel,
then you may wish to follow these steps. The following steps can guide you on
modifying DeadBot accordingly.

1. Download the latest copy from GitHub.

2. Open index.php in your favourite text editor. Replace "irc.x10hosting.com"
on Line 19 of index.php with your IRC server hostname.

3. Use your text editor's find/replace feature (usually CTRL+F) to replace all
instances of #publicchat with your channel name.

4. Comment out line 22 for now (place a // at the start of the line). If you
would like to use identification, you can use the RAW command to set it up
later.

5. Open cmd.php in your favourite text editor. Find all instances of
/home/kloxo/httpd/default/irc/ and replace it with the physical path to the
directory in which your files are in.

6. Ensure that shell_exec is enabled in your php.ini and ensure that 'screen'
is installed on your system.

7. Now you need to configure DeadBot, Luckily tomtiger11 has made an installer! To do this, login to your SSH terminal and cd into the directory which
your files are in. Run this command and follow all of the instructions: ``php installer.php``

8. You should now be able to start the bot up and solve any problems that may
occur.  Run this command: ``screen php index.php``

You can also run in debug mode:
``screen php index.php debug``

## Updates and Information ##
DeadBot is constantly under development, therefore please create a new GitHub
issue if you find any bugs or have any suggestions for me. Thanks! :)

-Deadi