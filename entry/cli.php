<?php
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
Usage:
    {$_SERVER['argv'][0]} [-h|--host HOSTNAME] PATH [PARAM1 [PARAM2 [...]]]


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