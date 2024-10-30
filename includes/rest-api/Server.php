<?php

/**
 * Initialize this version of the REST API.
 *
 * @package Corksy\RestApi
 */

defined('ABSPATH') || exit;


require_once __DIR__ . '/class-corksy-rest-settings-controller.php';

class Server
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_rest_routes'), 10);
    }

    public function init()
    {
        add_action('rest_api_init', array($this, 'register_rest_routes'), 10);
    }

    public function register_rest_routes()
    {
        $controller = new CORKSY_REST_Settings_Controller();
        $controller->register_routes();
    }
}

new Server();
