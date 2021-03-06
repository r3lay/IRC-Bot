<?php
return array(
    'server'   => 'irc.freenode.org',
    'port'     => 6667,
    'name'     => 'phpbot',
    'nick'     => 'phpbot',
    'channels' => array(
        '#phpbot404',
    ),
    'max_reconnects' => 1,
    'log_file'       => 'log.txt',
    'commands'       => array(
        'Command\Say'     => array(),
        'Command\Weather' => array(
            'yahooKey' => 'a',
        ),
	'Command\Fml'    => array(),
        'Command\Joke'    => array(),
        'Command\Ip'      => array(),
        'Command\Imdb'    => array(),
		'Command\Movie'    => array(),
        'Command\Poke'    => array(),
        'Command\Join'    => array(),
        'Command\Part'    => array(),
        'Command\Timeout' => array(),
	'Command\Twitter'    => array(),
	'Command\Urban'    => array(),
        'Command\Quit'    => array(),
        'Command\Restart' => array(),
	'Command\Wiki' => array(),
    ),
    'listeners' => array(
        'Listener\Joins' => array(),
    ),
);
