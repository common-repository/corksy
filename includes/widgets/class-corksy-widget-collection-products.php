<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Collection_Products extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_collection_products';
        $this->widget_description = __("A list of your store's products.", 'corksy');
        $this->widget_id          = 'corksy_collection_products';
        $this->widget_name        = __('Collection Products list', 'corksy');
        $this->block_name = "product-collection";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-product-collection">Collection Products</div>';
        $this->enqueue_script();
    }
}
