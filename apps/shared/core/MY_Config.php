<?php

/**
 * Use CI_HTTP_HOST constant to overwrite base_url host
 *
 */
class MY_Config extends CI_Config
{

    public function __construct()
    {
        $this->config =& get_config();

        // Set the base_url automatically if none was provided
        if (empty($this->config['base_url']))
        {
            $use_host = 'localhost';
            if (defined('CI_HTTP_HOST') && CI_HTTP_HOST) {
                $use_host = CI_HTTP_HOST;
            }
            else if (isset($_SERVER['SERVER_ADDR']))
            {
                $use_host = $_SERVER['SERVER_ADDR'];
            }

            $base_url = (is_https() ? 'https' : 'http').'://'.$use_host;
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $base_url .= substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
            }

            $this->set_item('base_url', $base_url);
        }

        log_message('info', 'Config Class Initialized');
    }
}

# EOF