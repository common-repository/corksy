<?php

/**
 * Installation related functions and actions.
 */

defined('ABSPATH') || exit;

class Corksy_Install
{

    public static function install()
    {
        #Check if we are not already running this routine.
        if (self::is_installing()) {
            return;
        }

        set_transient('corksy_admin_installing', 'yes', MINUTE_IN_SECONDS * 10);

        self::create_tables();

        delete_transient('corksy_admin_installing');

        add_option('corksy_admin_install_timestamp', time());
        do_action('corksy_admin_installed');
        add_option('activated_plugin', true);
    }

    public static function is_installing()
    {
        return 'yes' === get_transient('corksy_admin_installing');
    }

    public static function create_tables()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta(self::get_schema());
    }

    protected static function get_schema()
    {
        global $wpdb;

        $collate = $wpdb->has_cap('collation') ? $wpdb->get_charset_collate() : '';

        $tables = "
        CREATE TABLE {$wpdb->prefix}corksy_settings (
			id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			app_key     varchar(255) NOT NULL,
			PRIMARY KEY (id)
		) $collate;
        ";
        return $tables;
    }

    public static function get_tables()
    {
        global $wpdb;

        return array(
            "{$wpdb->prefix}corksy_settings",
        );
    }

    public static function drop_tables()
    {
        global $wpdb;

        $tables = self::get_tables();

        foreach ($tables as $table) {
            /* phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared */
            $wpdb->query("DROP TABLE IF EXISTS {$table}");
            /* phpcs:enable */
        }
    }
}

#Corksy_Install::init();
