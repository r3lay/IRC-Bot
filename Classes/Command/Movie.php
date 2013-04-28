<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to the channel, like say from a user.
 * arguments == movie title to search for
 * 
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Movie extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!movie [movie name]';
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
		$movieTerm = implode(' ', $this->arguments);
		$movieTerm = preg_replace('/\s\s+/', ' ', $movieTerm);
		$movieTerm = trim($movieTerm);
		$movieTerm = urlencode($movieTerm);
		
			if (!strlen($movieTerm))
			{
            $this->say(sprintf('Enter search term. (Usage: !movie [movie name])'));
            return;
			}
		
		$url = 'http://www.imdbapi.com/?i=&t='.$movieTerm;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$object = json_decode($page);
		$this->say("Plot: ".$object->Plot);
		sleep(2);
		$this->say("Actors: ".$object->Actors);
		sleep(2);
		$this->say("Idmb Rating: ".$object->imdbRating);
    
	}
   
}
?>