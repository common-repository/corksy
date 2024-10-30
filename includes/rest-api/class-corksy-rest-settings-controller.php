<?php

/**
 * REST API Settings controller
 *
 * Handles requests to the /settings endpoints.
 *
 * @package Corksy\RestApi
 * @since   0.0.1
 */

defined('ABSPATH') || exit;

class CORKSY_REST_Settings_Controller
{
    protected $namespace = 'corksy/v1';
    protected $rest_base = 'settings';


    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                'methods'             => 'GET',
                'callback'            => array($this, 'get_settings'),
                'permission_callback' => array($this, 'get_settings_permissions_check'),
            ],
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                'methods'             => 'POST',
                'callback'            => array($this, 'save_settings'),
                'permission_callback' => array($this, 'save_settings_permissions_check'),
            ],
        );
    }

    public function get_settings()
    {
        global $wpdb;
        $tableName = "{$wpdb->prefix}corksy_settings";
        $results = $wpdb->get_results("SELECT app_key FROM $tableName");

        return rest_ensure_response($results);
    }

    public function get_settings_permissions_check()
    {
        return true;
    }

    public function save_settings($req)
    {
        $appKey = sanitize_text_field($req['appKey']);
        global $wpdb;
        $tableName = "{$wpdb->prefix}corksy_settings";

        $this->delete_settings($wpdb, $tableName);

        $wpdb->insert(
            $tableName,
            [
                'app_key' => $appKey,
            ],
            [
                '%s',
            ]
        );

        return rest_ensure_response('success');
    }

    public function save_settings_permissions_check()
    {
        return true;
    }

    private function delete_settings($wpdb, $tableName)
    {
        $wpdb->query("DELETE FROM $tableName");
    }
}
