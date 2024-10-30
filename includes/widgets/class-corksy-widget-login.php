<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Login extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_login';
        $this->widget_description = __("Customer login.", 'corksy');
        $this->widget_id          = 'corksy_login';
        $this->widget_name        = __('Customer Login', 'corksy');
        $this->block_name = "login";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-login">Login</div>';
        $this->enqueue_script();
    }
}
