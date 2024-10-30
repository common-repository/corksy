<?php


defined('ABSPATH') || exit;

// Load core packages and the autoloader.
require __DIR__ . '/BlockTypes/Login.php';
require __DIR__ . '/BlockTypes/Register.php';
require __DIR__ . '/BlockTypes/WineEvents.php';
require __DIR__ . '/BlockTypes/WineEventBooking.php';
require __DIR__ . '/BlockTypes/Account.php';
require __DIR__ . '/BlockTypes/Orders.php';
require __DIR__ . '/BlockTypes/WineClubs.php';
require __DIR__ . '/BlockTypes/Subscription.php';


class CorksyCommerceGutenbergBlock
{

    function register()
    {
        $block_types = $this->get_block_types();
        foreach ($block_types as $block_type) {
            $block_type_class    =  $block_type;
            $block_type_instance = new $block_type_class();
        }
    }

    function get_block_types()
    {
        $block_types = [
            'Login',
            'Register',
            'WineEvents',
            'WineEventBooking',
            'Account',
            'Orders',
            'WineClubs',
            'Subscription'
        ];
        return $block_types;
    }
}
