<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Constantes para imagenes
|--------------------------------------------------------------------------
*/

define("NOVEDAD_PREVIEW_WIDTH", 186);
define("NOVEDAD_PREVIEW_HEIGHT", 140);
define("NOVEDAD_THUMB_WIDTH", 110);
define("NOVEDAD_THUMB_HEIGHT", 69);
define("NOVEDAD_IMAGE_QUALITY", 100);
define("NOVEDAD_IMAGE_PREVIEW_MARKER", ".prv");
define("NOVEDAD_IMAGE_THUMB_MARKER", ".thu");

define("CATEGORIA_PRODUCTO_PREVIEW_WIDTH", 158);
define("CATEGORIA_PRODUCTO_PREVIEW_HEIGHT", 200);
define("CATEGORIA_PRODUCTO_THUMB_WIDTH", 110);
define("CATEGORIA_PRODUCTO_THUMB_HEIGHT", 69);
define("CATEGORIA_PRODUCTO_IMAGE_QUALITY", 100);
define("CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER", ".prv");
define("CATEGORIA_PRODUCTO_IMAGE_THUMB_MARKER", ".thu");

define("PRODUCTO_PREVIEW_WIDTH", 186);
define("PRODUCTO_PREVIEW_HEIGHT", 140);
define("PRODUCTO_THUMB_WIDTH", 110);
define("PRODUCTO_THUMB_HEIGHT", 69);
define("PRODUCTO_IMAGE_QUALITY", 100);
define("PRODUCTO_IMAGE_PREVIEW_MARKER", ".prv");
define("PRODUCTO_IMAGE_THUMB_MARKER", ".thu");

/* End of file constants.php */
/* Location: ./application/config/constants.php */