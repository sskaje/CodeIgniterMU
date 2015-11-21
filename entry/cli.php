<?php

/**
 * CodeIgniter MUltiple Site Command Line Interface Entry
 *
 * CodeIgniter MUltiple Site
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


if (php_sapi_name() != 'cli') {
    header('HTTP/1.0 404 Not Found');

    echo <<<CLI
Page not found.

CLI;

    exit;
}

function cli_usage($msg = '')
{
    echo <<<USAGE
CodeIgniterMU CLI

Author: sskaje
Usage:
    {$_SERVER['argv'][0]} -h|--host HOSTNAME PATH [PARAM1 [PARAM2 [...]]]


USAGE;
    if ($msg) {
        echo "Error: $msg\n\n";
    }

    exit;
}

if (isset($_SERVER['argv'][1])) {
    if ($_SERVER['argv'][1] == '-H' || $_SERVER['argv'][1] == '--help') {
        cli_usage();
    }

    if ($_SERVER['argv'][1] == '-h' || $_SERVER['argv'][1] == '--host') {
        if (!isset($_SERVER['argv'][2])) {
            cli_usage("Missing hostname");
        }

        if (!preg_match('#^([a-z0-9]+\.)+[a-z0-9]+$#i', $_SERVER['argv'][2])) {
            cli_usage("Invalid hostname");
        }

        $_SERVER['HTTP_HOST'] = $_SERVER['argv'][2];
        unset($_SERVER['argv'][1], $_SERVER['argv'][2]);
    }
}

require(__DIR__ . '/index.php');

# EOF