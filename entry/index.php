<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */


/**
 * CodeIgniter MUltiple Site
 *
 * A multiple-site solution for CodeIgniter
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - , sskaje
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniterMU
 * @author	sskaje
 * @copyright	Copyright (c) 2015 - , sskaje (http://sskaje.me/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

# PHP 5.6+ required
version_compare(PHP_VERSION, '5.6', '>=') or die('PHP 5.6+ only');

# INT64 REQUIRED!
if (PHP_INT_SIZE < 8) {
	die('64-bit PHP only.');
}

define('CI_ROOT', realpath(__DIR__ . '/..'));

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same directory
 * as this file.
 */
$system_path = CI_ROOT . '/CodeIgniter/system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder than the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$application_folder = CI_ROOT . '/apps/';


/*
 *---------------------------------------------------------------
 * Host Mapping
 *---------------------------------------------------------------
 *
 * Map request HTTP_HOST to /apps/FOLDER_NAME/
 *
 */
$host_mapping = include(__DIR__ . '/host_mapping.php');
if (!isset($host_mapping[ENVIRONMENT])) {
	die("Invalid Host Mapping Configuration\n");
}
$host_mapping = $host_mapping[ENVIRONMENT];

if (!isset($_SERVER['HTTP_HOST'])) {
	die("Missing HTTP_HOST\n");
}

if (!preg_match('#^([a-z0-9\-]+\.)*[a-z0-9\-]+$#', $_SERVER['HTTP_HOST'])) {
	die("Malformed HTTP_HOST detected!\n");
}

$hostname = $_SERVER['HTTP_HOST'];

unset($_SERVER['CI_SITE']);

# Use CI_SITE to avoid setting base_url in all config.php
if (ENVIRONMENT === 'production')
{
	# Production mode, directly match
	if (isset($host_mapping[$hostname]))
	{
		$_SERVER['CI_SITE'] = $host_mapping[$hostname];
	}
	else
	{
		header('Location: ' . $host_mapping['default']);
		exit;
	}
}
else
{
	# Non-production mode, match by fnmatch()
	if (isset($host_mapping[$hostname])) {
		$_SERVER['CI_SITE'] = $host_mapping[$hostname];
	}
	else
	{
		foreach ($host_mapping as $hm=>$site)
		{
			if (fnmatch($hm, $hostname))
			{
				$_SERVER['CI_SITE'] = $site;
				break;
			}
		}
	}

	if (empty($_SERVER['CI_SITE']))
	{
		$_SERVER['CI_SITE'] = $host_mapping['default'];
	}
}

$application_folder .= $_SERVER['CI_SITE'];

define('CI_HTTP_HOST', $hostname ? : $_SERVER['CI_SITE']);


/*
 *---------------------------------------------------------------
 * Unique Instance ID
 *---------------------------------------------------------------
 *
 */
define('CI_INSTANCE_ID', uniqid('CI', true));

/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

// Is the system path correct?
if ( ! is_dir($system_path))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

# Path to the system folder
define('BASEPATH', $system_path . '/');

# Name of the "resource folder"
define('RSCPATH', CI_ROOT . '/resource');

# Name of common data folder
define('DATAPATH', CI_ROOT . '/data');

# Name of file cache folder
define('CACHEPATH', DATAPATH . '/cache');

# Application Path constant
define('APPPATH', $application_folder . '/');

# View Path constant
define('VIEWPATH', APPPATH . 'views/');


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */

require_once CI_ROOT.'/CodeIgniter/system/core/CodeIgniter.php';

# EOF
