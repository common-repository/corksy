<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Checkout extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_checkout';
        $this->widget_description = __("Customer checkout.", 'corksy');
        $this->widget_id          = 'corksy_checkout';
        $this->widget_name        = __('Checkout', 'corksy');
        $this->block_name = "vino-checkout";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-checkout">Checkout</div>';
        $this->enqueue_script();
    }
}
