<?php

/**
 * Corksy Uninstall
 *
 * Uninstalling Corksy deletes pages, tables, and options.
 *
 * @package Corksy\Uninstaller
 * @version 0.0.1
 */


if (!defined('ABSPATH')) exit;

include_once CKSY_PATH . 'corksy-admin/internal/Install.php';

Corksy_Install::drop_tables();
wp_cache_flush();
