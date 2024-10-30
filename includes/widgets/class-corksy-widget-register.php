<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Register extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_register';
        $this->widget_description = __("Customer account register.", 'corksy');
        $this->widget_id          = 'corksy_register';
        $this->widget_name        = __('Customer Register', 'corksy');

        $this->block_name = "register";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-register">Register</div>';
        $this->enqueue_script();
    }
}
