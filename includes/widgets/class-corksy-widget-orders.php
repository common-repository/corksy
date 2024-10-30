<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Orders extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_orders';
        $this->widget_description = __("Customer orders.", 'corksy');
        $this->widget_id          = 'corksy_orders';
        $this->widget_name        = __('Customer orders', 'corksy');

        $this->block_name = "orders";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-orders">Orders</div>';
        $this->enqueue_script();
    }
}
