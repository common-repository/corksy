<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Products extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_products';
        $this->widget_description = __("A list of your store's products.", 'corksy');
        $this->widget_id          = 'corksy_products';
        $this->widget_name        = __('Products list', 'corksy');

        $this->block_name = "all-products";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-all-products">ALL Products</div>';
        $this->enqueue_script();
    }
}
