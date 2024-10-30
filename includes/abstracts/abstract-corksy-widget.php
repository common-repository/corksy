<?php


if (!defined('ABSPATH')) {
    exit;
}

abstract class Corksy_Widget extends WP_Widget
{
    public $widget_cssclass;

    public $widget_description;

    public $widget_id;

    public $widget_name;

    public $settings;

    public $block_name;

    public function __construct()
    {
        $widget_ops = array(
            'classname'                   => $this->widget_cssclass,
            'description'                 => $this->widget_description,
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        );

        parent::__construct($this->widget_id, $this->widget_name, $widget_ops);
    }


    public function form($instance)
    {
        if (empty($this->settings)) {
            return;
        }
    }


    public function register_script()
    {
        # echo  'build/' . $this->block_name . '-frontend.asset.php </br>';
        $script_path       =    'build/' . $this->block_name . '-frontend.js';
        $script_asset_path =   CKSY_ROOT_PATH . 'build/' . $this->block_name . '-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = CKSY_PLUGIN_DIR_URL . $script_path;

        wp_register_script('vi-' . $this->block_name . '-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
    }

    public function enqueue_script()
    {
        wp_enqueue_script('vi-' . $this->block_name . '-block-frontend');
    }
}
