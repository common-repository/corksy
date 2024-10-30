<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Wine_Subscription extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_wine_subscription';
        $this->widget_description = __("Corksy subscription", 'corksy');
        $this->widget_id          = 'corksy_subscription';
        $this->widget_name        = __('Corksy subscription', 'corksy');

        $this->block_name = "subscription";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-subscription">Subscription</div>';
        $this->enqueue_script();
    }
}
