<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Product_Collections extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_product_collections';
        $this->widget_description = __("A list of product collections.", 'corksy');
        $this->widget_id          = 'corksy_product_collections';
        $this->widget_name        = __('Products collections', 'corksy');

        $this->block_name = "product-collections";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-product-collections">Product Collections</div>';
        $this->enqueue_script();
    }
}
