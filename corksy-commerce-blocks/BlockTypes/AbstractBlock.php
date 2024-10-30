<?php

abstract class AbstractBlock
{
    protected $namespace = "vino";
    protected $block_name = '';

    public function __construct()
    {
        $this->initialize();
    }

    protected function initialize()
    {
        $this->register_block_type();
    }

    protected function register_block_type()
    {
        register_block_type($this->get_block_type(), array(
            'render_callback' => [$this, 'render_callback'],
            'editor_script' => 'vi-all-products-block',
            "editor_style" => 'vino-style',
            "style" => "vino-style"
        ));
    }

    protected function get_block_type()
    {
        return $this->namespace . '/' . $this->block_name;
    }

    public function render_callback($attributes = [], $content = '')
    {
        if (!is_admin()) {
            $this->enqueue_scripts();
        }
        return $this->add_attributes_to_block($attributes, $content);
    }

    protected function enqueue_scripts(array $attributes = [])
    {
        $script_path       =    'build/' . $this->block_name . '-frontend.js';
        $script_asset_path =   CKSY_ROOT_PATH . 'build/' . $this->block_name . '-frontend.asset.php';
        $script_asset      = require($script_asset_path);
        $script_url = CKSY_PLUGIN_DIR_URL . $script_path;

        wp_enqueue_script('vi-' . $this->block_name . '-block-frontend', $script_url, $script_asset['dependencies'], $script_asset['version']);
    }

    function add_attributes_to_block($attributes = [], $content = '')
    {
        return preg_replace('/^<div /', '<div ' .  ' ', trim($content));
    }
}
