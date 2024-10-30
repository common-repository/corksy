<?php
defined('ABSPATH') or exit;


include_once CKSY_ABSPATH . 'includes/class-corksy-install.php';

class Corksy_Setup_Class
{
    protected static $instance;

    public function __construct()
    {
    }

    public static function init()
    {
        is_null(self::$instance) and self::$instance = new self;
        return self::$instance;
    }

    public static function on_activation()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        check_admin_referer("activate-plugin_{$plugin}");

        Corksy_Install::install();
    }

    public static function on_deactivation()
    {
        if (!current_user_can('activate_plugins'))
            return;
        $plugin = isset($_REQUEST['plugin']) ? $_REQUEST['plugin'] : '';
        check_admin_referer("deactivate-plugin_{$plugin}");

        Corksy_Install::drop_tables();
        add_option('deactivated_plugin', true);
    }

    public static function on_uninstall()
    {
        if (!current_user_can('activate_plugins'))
            return;
        check_admin_referer('bulk-plugins');

        Corksy_Install::drop_tables();
        if (__FILE__ != WP_UNINSTALL_PLUGIN)
            return;
    }
}
