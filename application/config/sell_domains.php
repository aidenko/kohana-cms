<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	'url' => 'https://www.ukraine.com.ua/info/resellers/',
	//it is pricefor selling
	'sell_price' => 'silver',
	'sell_interest' => 0.1,
	'sell_currency' => 'грн',
	
	'db' => array(
		'domains' => 'sell_domain',
		'archive' => 'sell_domain_archive',
		'price' => 'sell_domain_price' 
	)
);
