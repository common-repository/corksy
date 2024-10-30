<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Wine_Events extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_wine_events';
        $this->widget_description = __("Wine events.", 'corksy');
        $this->widget_id          = 'corksy_wine_events';
        $this->widget_name        = __('Wine events', 'corksy');

        $this->block_name = "wine-events";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-wine-events">Wine Events</div>';
        $this->enqueue_script();
    }
}
