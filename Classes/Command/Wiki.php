<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to wiki search.
 * arguments == term to search for.
 * 
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Wiki extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!wiki [search term]';
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
		$wikiTerm = implode(' ', $this->arguments);
		$wikiTerm = preg_replace('/\s\s+/', ' ', $wikiTerm);
		$wikiTerm = trim($wikiTerm);
		$wikiTerm = urlencode($wikiTerm);
		
			if (!strlen($wikiTerm))
			{
            $this->say(sprintf('Enter search term. (Usage: !wiki search term)'));
            return;
			}
		
		$url = "http://en.wikipedia.org/w/api.php?action=opensearch&search=".$wikiTerm."&format=xml&limit=1";
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
		$xml = simplexml_load_string($page);
		
		$desc = $xml->Section->Item->Description;
		$text = $xml->Section->Item->Text;
		
		$this->say($desc);
    
	}
   
}
?>