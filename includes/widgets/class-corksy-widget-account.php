<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Account extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_account';
        $this->widget_description = __("Customer account.", 'corksy');
        $this->widget_id          = 'corksy_account';
        $this->widget_name        = __('Customer Account', 'corksy');
        $this->block_name = "account";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-account">Account</div>';
        $this->enqueue_script();
    }
}
