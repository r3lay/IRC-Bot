<?php
    /**
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created 30.12.2011 20:29:55
     *
     * @filesource
     */

    namespace Library\IRC\Command;

    /**
     * An IRC command.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    abstract class Base {

        /**
         * Reference to the IRC Connection.
         * @var \Library\IRC\Connection
         */
        protected $connection = null;

        /**
         * Reference to the IRC Bot
         * @var \Lirary\IRC\Bot
         */
        protected $bot = null;

        /**
         * Contains all given arguments.
         * @var array
         */
        protected $arguments = array ( );

        /**
         * Contains channel or user name
         *
         * @var string
         */
        protected $source = null;

        /**
         * Original request from server
         *
         * @var string
         */
        private $data;

        /**
         * The number of arguments the command needs.
         *
         * You have to define this in the command.
         *
         * @var integer
         */
        protected $numberOfArguments = 0;

        /**
         * The help string, shown to the user if he calls the command with wrong parameters.
         *
         * You have to define this in the command.
         *
         * @var string
         */
        protected $help = '';

        /**
         * Executes the command.
         *
         * @param array           $arguments The assigned arguments.
         * @param string          $source    Originating request
         * @param string          $data      Original data from server
         */
        public function executeCommand( array $arguments, $source, $data ) {
            // Set source
            $this->source = $source;

            // Set data
            $this->data = $data;

            // If a number of arguments is incorrect then run the command, if
            // not then show the relevant help text.
            if ($this->numberOfArguments != -1 && count( $arguments ) != $this->numberOfArguments) {
                // Show help text.
                $this->say(' Incorrect Arguments. Usage: ' . $this->getHelp());
            }
            else {
                // Set Arguments
                $this->arguments = $arguments;

                // Execute the command.
                $this->command();
            }
        }

        /**
         * Sends PRIVMSG to source with $msg
         *
         * @param string $msg
         */
       protected function say($msg) {
            $this->connection->sendData(
                    'PRIVMSG ' . $this->source . ' :' . $msg
            );
        }

        private function getHelp() {
           return $this->help;
        }

        /**
         * Overwrite this method for your needs.
         * This method is called if the command get's executed.
         */
        public function command() {
            echo 'fail';
            flush();
            throw new Exception( 'You have to overwrite the "command" method and the "executeCommand". Call the parent "executeCommand" and execute your custom "command".' );
        }

        /**
         * Set's the IRC Connection, so we can use it to send data to the server.
         * @param \Library\IRC\Connection $ircConnection
         */
        public function setIRCConnection( \Library\IRC\Connection $ircConnection ) {
            $this->connection = $ircConnection;
        }

        /**
         * Set's the IRC Bot, so we can use it to send data to the server.
         *
         * @param \Library\IRCBot $ircBot
         */
        public function setIRCBot( \Library\IRC\Bot $ircBot ) {
            $this->bot = $ircBot;
        }

        /**
         * Returns requesting user IP
         *
         * @return string
         */
        protected function getUserIp() {
            // catches from @ to first space
            if (preg_match('/@([a-z0-9.-]*) /i', $this->data, $match) === 1) {
                $hostname = $match[1];

                $ip = gethostbyname($hostname);

                // did we really get an IP
                if (preg_match( '/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $ip ) === 1) {
                    return $ip;
                }
            }

            return null;
        }

        /**
         * Fetches data from $uri
         *
         * @param string $uri
         * @return string
         */
        protected function fetch($uri) {

            $this->bot->log("Fetching from URI: " . $uri);

            // create curl resource
            $ch = curl_init();

            // set url
            curl_setopt($ch, CURLOPT_URL, $uri);

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

            // $output contains the output string
            $output = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);

            $this->bot->log("Data fetched: " . $output);

            return $output;
        }
		/**
         * Build font codes array
         *
         */
		public $fontselect = array(
					'c'	=>	"\x03", // Color - followed by 2 digit color code
					'n'	=>	"\x0f", // Reset
					'b'	=>	"\x02", // Bold
					'u'	=>	"\x1f", // Underline
					's'	=>	"\x13", // Strike-Through
					'i'	=>	"\x09", // Italic
					'r'	=>	"\x16", // Reverse
		);
		
		/** Build color codes array
        *
        */
		public $colorselect = array(
					'black' => "00",
					'white' => "01",
					'blue' => "02",
					'green' => "03",
					'red' => "04",
					'brown' => "05",
					'purple' => "06",
					'orange' => "07",
					'yellow' => "08",
					'limegreen' => "09",
					'turquoise' => "10",
					'cyan' => "11",
					'lightblue' => "12",
					'pink' => "13",
					'grey' => "14",
					'lightgrey' => "15"
		);
		/** Return string with font and font color
        *@param string $font,$color,$string
		*EX: $this->fontandcolor('b','blue','i will be bold and blue')
        *@return string
        */
		public function fontandcolor($font,$color,$string){
			return $this->fontselect[$font].$this->fontselect['c'].$this->colorselect[$color].$string.$this->fontselect['c'].$this->fontselect[$font];
		}
		
		/** Return string with font
        *@param string $font,$string
		*EX: $this->fontandcolor('b','i will be bold')
        *@return string
        */
		public function textFont($font,$string){
			return $this->fontselect[$font].$string.$this->fontselect[$font];
		}
		
		/** Return string with colored font
        *@param string $color,$string
		*EX: $this->fontandcolor('cyan','i will be cyan color')
        *@return string
        */
		public function textColor($font,$string){
			return $this->fontselect['c'].$this->colorselect[$color].$string.$this->fontselect['c'];
		}
    }
?>
