<?php
// Namespace
namespace Command;

/**
 * 
 * 
 * 
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Fml extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!fml';
    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = 0;

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
	 
	public function fmlData(){
		$url = "http://rscript.org/lookup.php?type=fml";
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
		$data = curl_exec($ch);
		return $data;
	}
	
	
	public function stripFmlText($data){
		$startText =  strstr($data,"TEXT");
		$endText = strstr($startText,"FML", true);
		return substr($endText,6);
	
	}
	 
	

    public function command() {
		$fullData = $this->fmlData();
		$this->say($this->stripFmlText($fullData));
    
	}
   
}
?>