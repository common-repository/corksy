<?php

if (!defined('ABSPATH')) {
    exit;
}


require_once dirname(__FILE__) . '/abstracts/abstract-corksy-widget.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-account.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-checkout.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-collection-products.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-login.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-orders.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-product-collections.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-products.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-register.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-wine-clubs.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-wine-event-booking.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-wine-events.php';
require_once dirname(__FILE__) . '/widgets/class-corksy-widget-wine-subscription.php';

function wc_register_widgets()
{
    register_widget('Corksy_Widget_Account');
    register_widget('Corksy_Widget_Checkout');
    register_widget('Corksy_Widget_Collection_Products');
    register_widget('Corksy_Widget_Login');
    register_widget('Corksy_Widget_Orders');
    register_widget('Corksy_Widget_Product_Collections');
    register_widget('Corksy_Widget_Products');
    register_widget('Corksy_Widget_Register');
    register_widget('Corksy_Widget_Wine_Clubs');
    register_widget('Corksy_Widget_Wine_Events');
    register_widget('Corksy_Widget_Wine_Event_Booking');
    register_widget('Corksy_Widget_Wine_Subscription');
}

add_action('widgets_init', 'wc_register_widgets');

function my_plugin_editor_scripts()
{

    wp_register_script(
        'editor-script-1',
        CKSY_PLUGIN_DIR_URL . "build/index.js",
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
    );
    // wp_register_script('editor-script-2', plugins_url('assets/js/editor-script-2.js', __FILE__), ['external-library']);
    // wp_register_script('external-library', plugins_url('assets/js/libs/external-library.js', __FILE__));

    wp_enqueue_script('editor-script-1');
}
add_action('elementor/editor/after_enqueue_scripts', 'my_plugin_editor_scripts');
