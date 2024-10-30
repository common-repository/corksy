<?php

/**
 * Plugin Name: Corksy
 * Plugin URI: https://brandclick.com/
 * Description: Corksy.
 * Version: 0.0.16
 * Author: Brightspot, BrandClick
 * Author URI: https://brandclick.com/
 * Text Domain: Corksy
 * Domain Path: /i18n/languages/
 * Requires at least: 5.6
 * Requires PHP: 7.0
 *
 * @package Corksy
 */


if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!defined('CKSY_PLUGIN_FILE')) {
    define('CKSY_PLUGIN_FILE', __FILE__);
}

define('CKSY_ROOT_PATH', __DIR__ . '/');
define('CKSY_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) . '/');
define('CKSY_PATH', plugin_dir_path(__FILE__));
define('CKSY_URL', plugins_url('/', __FILE__));
define('CKSY_ABSPATH', dirname(CKSY_PLUGIN_FILE) . '/');

require_once CKSY_PATH . 'corksy-commerce-blocks/CorksyCommerceGutenbergBlock.php';
require_once CKSY_PATH . 'corksy-admin/CorksyAdmin.php';
require_once CKSY_PATH . 'Corksy_Setup_Class.php';

register_activation_hook(__FILE__, array('Corksy_Setup_Class', 'on_activation'));
register_deactivation_hook(__FILE__, array('Corksy_Setup_Class', 'on_deactivation'));
register_uninstall_hook(__FILE__, array('Corksy_Setup_Class', 'on_uninstall'));
add_action('plugins_loaded', array('Corksy_Setup_Class', 'init'));

if (!class_exists('Corksy', false)) {
    include_once dirname(CKSY_PLUGIN_FILE) . '/includes/class-corksy.php';
}

function CC()
{
    return Corksy::instance();
}
class CorksyCommerce
{

    function __construct()
    {
        add_filter('block_categories_all', [$this, 'wpdocs_add_new_block_category'], 10, 2);
        add_filter('wp_nav_menu_items', [$this, 'add_login_button_to_nav_menu'], 10, 2);
        add_filter('wp_nav_menu_items', [$this, 'add_cart_button_to_nav_menu'], 10, 2);
        add_action('init', [$this, 'onInit']);
        $filter_name = "plugin_action_links_" . plugin_basename(__FILE__);
        add_filter($filter_name, [$this, 'add_settings_link'], 10, 2);
    }

    function onInit()
    {
        wp_register_script(
            'vi-all-products-block',
            plugin_dir_url(__FILE__) . 'build/index.js',
            array('wp-block-editor', 'wp-blocks', 'wp-editor', 'wp-element')
        );

        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );

        wp_add_inline_script("vi-all-products-block", 'window.vino = ' . wp_json_encode($data), 'before');

        wp_register_style(
            'vino-style1',
            plugin_dir_url(__FILE__) . 'build/style-index.css'
        );

        wp_register_style(
            'vino-fa',
            plugin_dir_url(__FILE__) . 'fontawesome/css/all.min.css'
        );

        $css_dependencies = [
            'wp-block-library-theme',
            'wp-block-library',
            'vino-style1',
            'vino-fa'
        ];

        wp_register_style(
            'vino-style',
            plugin_dir_url(__FILE__) . 'build/index.css',
            $css_dependencies,
            time()
        );

        $this->enqueue_cart_drawer_script();
        $this->enqueue_auth_script();

        register_block_type('vino/all-products', array(
            'render_callback' => [$this, 'render_block'],
            'editor_script' => 'vi-all-products-block',
            "editor_style" => 'vino-style',
            "style" => "vino-style"
        ));

        register_block_type('vino/checkout', array(
            'render_callback' => [$this, 'render_checkout_block'],
            'editor_script' => 'vi-all-products-block',
            "editor_style" => 'vino-style',
            "style" => "vino-style"
        ));

        register_block_type('vino/product-collections', array(
            'render_callback' => [$this, 'render_product_collections_block'],
            'editor_script' => 'vi-all-products-block',
            "editor_style" => 'vino-style',
            "style" => "vino-style"
        ));

        register_block_type('vino/product-collection', array(
            'render_callback' => [$this, 'render_product_collection_block'],
            'editor_script' => 'vi-all-products-block',
            "editor_style" => 'vino-style',
            "style" => "vino-style"
        ));

        // register_block_type('vino/subscription-plans', array(
        //     'render_callback' => [$this, 'render_subscription_plans_block'],
        //     'editor_script' => 'vi-all-products-block',
        //     "editor_style" => 'vino-style',
        //     "style" => "vino-style"
        // ));

        $this->register_blocks();
        $this->registerAdminScripts();

        wp_localize_script('corksy-admin', 'appLocalizer', [
            'apiUrl' => home_url('/wp-json'),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }

    function wpdocs_add_new_block_category($block_categories, $editor_context)
    {
        return array_merge(
            $block_categories,
            [
                [
                    'slug'  => 'corksy',
                    'title' => 'Corksy',
                ],
                [
                    'slug'  => 'vino-blocks',
                    'title' => 'Vino',
                ],
            ]
        );
    }

    function render_block($attributes = [], $content = '')
    {
        if (!is_admin()) {
            $this->enqueue_frontend_script();
        }
        return $this->add_attributes_to_block($attributes, $content);
    }

    function render_checkout_block($attributes = [], $content = '')
    {
        if (!is_admin()) {
            $this->enqueue_checkout_frontend_script();
        }
        return $this->add_attributes_to_block($attributes, $content);
    }

    function render_product_collections_block($attributes = [], $content = '')
    {
        if (!is_admin()) {
            $this->enqueue_product_collections_frontend_script();
        }
        return $this->add_attributes_to_block($attributes, $content);
    }

    function render_product_collection_block($attributes = [], $content = '')
    {
        if (!is_admin()) {
            $this->enqueue_product_collection_frontend_script();
        }
        return $this->add_attributes_to_block($attributes, $content);
    }

    // function render_subscription_plans_block($attributes = [], $content = '')
    // {
    //     if (!is_admin()) {
    //         $this->enqueue_subscription_plans_frontend_script();
    //     }
    //     return $this->add_attributes_to_block($attributes, $content);
    // }

    function add_attributes_to_block($attributes = [], $content = '')
    {
        return preg_replace('/^<div /', '<div ' .  ' ', trim($content));
    }

    function enqueue_frontend_script()
    {
        $script_path       = 'build/all-products-frontend.js';
        $script_asset_path = 'build/all-products-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        wp_enqueue_script('vi-all-products-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );
        wp_add_inline_script("vi-all-products-block-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    function enqueue_checkout_frontend_script()
    {
        $script_path       = 'build/vino-checkout-frontend.js';
        $script_asset_path = 'build/vino-checkout-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        //wp_enqueue_script('google-map-js', '//maps.googleapis.com/maps/api/js?key=AIzaSyCK-VcjLofVgBWeOzuZI1zYHMmq14ByQX4&libraries=places'); // all the bootstrap javascript goodness
        wp_enqueue_script('vi-checkout-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );
        wp_add_inline_script("vi-checkout-block-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    function enqueue_product_collections_frontend_script()
    {
        $script_path       = 'build/product-collections-frontend.js';
        $script_asset_path = 'build/product-collections-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        wp_enqueue_script('vi-product-collections-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);

        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );

        wp_add_inline_script("vi-product-collections-block-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    function enqueue_product_collection_frontend_script()
    {
        $script_path       = 'build/product-collection-frontend.js';
        $script_asset_path = 'build/product-collection-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        wp_enqueue_script('vi-product-collection-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);

        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );

        wp_add_inline_script("vi-product-collection-block-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    // function enqueue_subscription_plans_frontend_script()
    // {
    //     $script_path       = 'build/subscription-plans-frontend.js';
    //     $script_asset_path = 'build/subscription-plans-frontend.asset.php';
    //     $script_asset      = require($script_asset_path);
    //     $script_url = plugins_url($script_path, __FILE__);

    //     wp_enqueue_script('vi-subscription-plans-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);

    //     $data = array(
    //         'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
    //     );

    //     wp_add_inline_script("vi-subscription-plans-block-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    // }

    function enqueue_cart_drawer_script()
    {
        $script_path       = 'build/vino-cart-drawer.js';
        $script_asset_path = 'build/vino-cart-drawer.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        wp_enqueue_script('vi-cart-drawer-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );

        wp_add_inline_script("vi-cart-drawer-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    function enqueue_auth_script()
    {
        $script_path       = 'build/vino-auth.js';
        $script_asset_path = 'build/vino-auth.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = plugins_url($script_path, __FILE__);

        wp_enqueue_script('vi-auth-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
        $data = array(
            'VINO_PLUGIN_URL'   => plugin_dir_url(__FILE__),
        );

        wp_add_inline_script("vi-auth-frontend", 'window.vino = ' . wp_json_encode($data), 'before');
    }

    function add_cart_button_to_nav_menu($items, $args)
    {
        $items .= '<li><a id="wp-vino-drawer"><i class="fa-solid fa-cart-shopping"></i></a></li>';
        return $items;
    }

    function add_login_button_to_nav_menu($items, $args)
    {
        $items .= '<div id="wp-vino-auth"></div>';
        return $items;
    }

    function register_blocks()
    {
        $block = new CorksyCommerceGutenbergBlock();
        $block->register();
    }

    function registerAdminScripts()
    {
        $admin = new CorksyAdmin();
        $admin->load_scripts();
    }


    function add_settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=corksy">' . __('Settings', 'corksy') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }
}

$vino = new CorksyCommerce();

$GLOBALS['corksy'] = CC();

require_once CKSY_PATH . 'includes/rest-api/Server.php';
