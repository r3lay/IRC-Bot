<?php
// Namespace
namespace Command;

/**
 * Gets last tweet from user specified
 * arguments == User to get tweet from.
 * 
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Twitter extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!twitter [user]';
    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
	

    public function command() {
		$user = implode(' ', $this->arguments);
		$user = preg_replace('/\s\s+/', ' ', $user);
		$user = trim($user);
		
		
		if (!strlen($user))
		{
		$this->say(sprintf('Enter user. (Usage: !twitter user)'));
		return;
		}
		
		$url = 'https://api.twitter.com/1/statuses/user_timeline/'.$user.'.xml?count=1&include_rts=1callback=?';

		$xml = simplexml_load_file($url) or die();

		foreach($xml->status as $status)
		{
		$text = $status->text;
		}
		$this->say($text);
	   
 	}
    
        
	
   
}
?>