<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to urban dictionary api
 * arguments] == [search term]
 * 
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Urban extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!urban [search term]';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;
	
	
	/**
     * Lookup term on urban dictionary api function
     *
     * 
     */
     public function urban_lookup($term) 
     {
	$url = 'http://api.urbandictionary.com/v0/define?term='.$term;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	$results = json_decode($data);
	return $results;
     }

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * 
     */
    public function command() 
    {
	$urbanTerm = implode(' ', $this->arguments);
	$urbanTerm = preg_replace('/\s\s+/', ' ', $urbanTerm);
	$urbanTerm = trim($urbanTerm);
	$urbanTerm = urlencode($urbanTerm);
		
		
	if (!strlen($urbanTerm))
	{
          $this->say(sprintf('Enter search term. (Usage: !urban [search term])'));return;
	}
			
				
			 
	if(!isset($urbanTerm)) die('no term specified');
	 
	$words = $this->urban_lookup($urbanTerm);
	 
	if($words->result_type == 'no_results')
	{
	   $this->say('Even urban dictionary hasn\'t heard of that, you sicko');
	   die();
	}
				 
				 
	$keys = array('definition');
	
	foreach($keys as $key)
	{
	   $this->say("Urban Dictionary - ".$urbanTerm);
	   $this->say($words->list[0]->$key);
	}
		
		
		
    }
}
?>
