<?php

/**
 * Corksy setup
 *
 * @package Corksy
 */


defined('ABSPATH') || exit;

final class Corksy
{
    public $version = '0.0.1';

    protected static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    public function includes()
    {
        include_once CKSY_ABSPATH . 'includes/class-corksy-install.php';
        include_once CKSY_ABSPATH . 'includes/corksy-core-functions.php';
    }

    private function define_constants()
    {
        # $this->define('CKSY_ABSPATH', dirname(CKSY_PLUGIN_FILE) . '/');
    }

    public function on_plugins_loaded()
    {
        do_action('corksy_loaded');
    }

    private function init_hooks()
    {
        // register_activation_hook(__FILE__, array('Corksy_Install', 'install'));
        register_shutdown_function(array($this, 'log_errors'));
        add_action('plugins_loaded', array($this, 'on_plugins_loaded'), -1);
        add_action('init', array($this, 'init'), 0);
        add_action('init', array($this, 'load_rest_api'));
        add_action('activated_plugin', array($this, 'activated_plugin'));
        add_action('deactivated_plugin', array($this, 'deactivated_plugin'));
        add_action('corksy_installed', array($this, 'corksy_installed'));
        add_action('corksy_updated', array($this, 'corksy_updated'));
    }

    public function init()
    {
    }

    public function load_rest_api()
    {
    }

    public function activated_plugin($filename)
    {
        wp_safe_redirect(admin_url('admin.php?page=corksy'));
    }

    public function deactivated_plugin($filename)
    {
    }

    public function corksy_installed()
    {
    }

    public function corksy_updated()
    {
    }

    public function log_errors()
    {
        $error = error_get_last();
        if ($error && in_array($error['type'], array(E_ERROR, E_PARSE, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR), true)) {

            do_action('corksy_shutdown_error', $error);
        }
    }
}
