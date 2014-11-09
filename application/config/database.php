<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
    (
      'type'       => 'MySQL',
      'connection' => array(
          'hostname'   => '',
          'username'   => '',
          'password'   => '',
          'persistent' => FALSE,
          'database'   => '',
      ),
      'table_prefix' => '',
      'charset'      => 'utf8',
    ),
	
	'default-pdo-example' => array
	(
		'type'       => 'PDO',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * array    variables    system variables as "key => value" pairs
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'dsn'   => '',
			'username'   => "",
			'password'   => "",
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	)
);
