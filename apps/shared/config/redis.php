<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Redis settings
| -------------------------------------------------------------------------
 */
$config = array(
	'default' => array(
		'host' => '127.0.0.1',
		'port' => 6379,
		'socket_type' => 'unix',
		'socket'      => '/var/run/redis/redis.sock',
		'password' => NULL,
		'timeout' => 0
	),
);

# EOF
