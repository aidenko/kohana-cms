<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Kiev');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'profile'	=>	true,
	'charset'	=> 'utf-8',
	'index_file' => false
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	// 'image'      => MODPATH.'image',      // Image manipulation
	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	'pagination'   	=> MODPATH.'pagination' ,       // pagination
	'email'   			=> MODPATH.'email'        // email
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('admin', 'admin(/<controller>(/<action>))')
	->defaults(array(
		'directory' => 'Admin',
		'controller' => 'dashboard',
		'action' 		=> 'index'
	));	

Route::set('template', 'template/main/block/<controller>(/<action>)')
	->defaults(array(
		'directory' => 'Template_Main_Block',
		//'sub_dir' => 'main',
		//'folder'    => 'block',
		'controllr' => 'header',
		'action' 		=> 'index'
	));	
	
Route::set('module', 'module/<controller>(/<action>(/<ct_id>(/<id>)))', array('ct_id' => '[0-9]+', 'id' => '[0-9]+'))
	->defaults(array(
		'directory' => 'Module',
		'controller' => 'header',
		'action' 		=> 'index',
		'ct_id'			=> '1',
		'id'				=> '1'
	));		
	
Route::set('action', 'action/<controller>(/<action>)')
	->defaults(array(
		'directory' => 'Action',
		'action' 		=> 'index',
	));		
	
Route::set('article', 'article(/<action>(/<id>))', array('id' => '[0-9]+'))
	->defaults(array(
		'controller' => 'article',
		'action'     => 'view',
		'id'				=> '1'
	));
	
Route::set('comments', 'comment(/<action>(/<ct_id>(/<id>(/<page>))))', array('ct_id' => '[0-9]+', 'id' => '[0-9]+', 'page' => '[0-9]+'))
	->defaults(array(
		'controller' => 'comment',
		'action'     => 'index',
		'ct_id'			=> '1',
		'id'				=> '1',
		'page'			=> '1'
	));

Route::set('loginform', '<lang>/<controller>/<action>',
		array(
			'controller' => 'loginform',
			'action'	=> 'login',
			//'la_id' => '\d+'
			'lang' => '[a-z]{2}'
	))
	->defaults(array(
		'controller' => 'loginform',
		'action'     => 'index',
		'lang'		=> 'en'
	));

Route::set('dashboard', '<lang>/<controller>(/<index>)',
	array(
		'controller' => 'dashboard',
		'action'	=> 'index',
		//'la_id' => '\d+'
		'lang' => '[a-z]{2}'
	))
	->defaults(array(
		'controller' => 'dashboard',
		'action'	=> 'index',
		//'la_id'	=>	null
		'lang' => 'en'
	));	

Route::set('default', '(<controller>(/<action>(/<page>)))')
	->defaults(array(
		'controller' => 'mainpage',
		'action'     => 'index',
		'page'			=> '1'
	));
	

	
Cookie::$salt = "H?%QW^cK";	
