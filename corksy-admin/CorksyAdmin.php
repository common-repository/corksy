<?php


defined('ABSPATH') || exit;

require_once CKSY_PATH . 'corksy-admin/includes/class-create-admin-menu.php';

class CorksyAdmin
{
    public function __construct()
    {
        $this->define('CORKSY_ADMIN_VERSION_NUMBER', '0.0.1');
    }

    function load_scripts()
    {
        wp_localize_script('corksy-admin', 'appLocalizer', [
            'apiUrl' => home_url('/wp-json'),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
        wp_enqueue_style('corksy-admin', CKSY_URL . 'build/corksy-admin.css', array(), wp_rand());
        wp_enqueue_script('wp-corksy', CKSY_URL . 'build/corksy-admin.js', ['wp-element'], wp_rand(), true);
    }

    protected function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }
}
