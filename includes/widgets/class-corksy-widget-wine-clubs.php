<?php

defined('ABSPATH') || exit;

class Corksy_Widget_Wine_Clubs extends Corksy_Widget
{

    function __construct()
    {
        $this->widget_cssclass    = 'corksy widget_wine_clubs';
        $this->widget_description = __("A list of wine clubs", 'corksy');
        $this->widget_id          = 'corksy_wine_clubs';
        $this->widget_name        = __('Wine clubs', 'corksy');

        $this->block_name = "wine-clubs";

        parent::__construct();
        $this->register_script();
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        echo '<div class="wp-block-vino-wine-clubs">Wine clubs</div>';
        $this->enqueue_script();
    }
}
