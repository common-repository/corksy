<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Wine_Event_Booking extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_wine_event_booking';
        $this->widget_description = __("Wine event booking.", 'corksy');
        $this->widget_id          = 'corksy_wine_event_booking';
        $this->widget_name        = __('Wine event booking', 'corksy');

        $this->block_name = "wine-event-booking";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-wine-event-booking">Wine event booking</div>';
        $this->enqueue_script();
    }
}
