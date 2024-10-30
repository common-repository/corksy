<?php

/**
 * This file will create admin menu page.
 */

class Corksy_Create_Admin_Page
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'create_admin_menu']);
    }

    public function create_admin_menu()
    {
        $capability = 'manage_options';
        $slug = 'corksy';
        add_menu_page('Corksy', 'Corksy', 'read', $slug, false);
        $menu_slug = 'corksy-settings';
        add_submenu_page($slug, 'Corksy Settings', 'Settings', $capability, $slug, [$this, 'menu_page_template'], 1);
        //add_submenu_page($slug, 'Corksy Settings', 'Settings2', $capability, $menu_slug, [$this, 'menu_page_template'], 1);
    }

    public function menu_page_template()
    {
        echo '<div class="wrap"><div id="corksy-admin-app"></div></div>';
    }
}
new Corksy_Create_Admin_Page();
