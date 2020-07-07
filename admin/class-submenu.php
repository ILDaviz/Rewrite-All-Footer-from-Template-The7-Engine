<?php
class Submenu {

    private $submenu_page;

    public function __construct( $submenu_page ) {
        $this->submenu_page = $submenu_page;
    }

    public function init() {
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    public function add_options_page() {

        add_options_page(
            'Rewrite Footer All Template The7 Templates',
            'Rewrite Footer The7',
            'manage_options',
            'rewrite-footer-the7',
            array( $this->submenu_page, 'render' )
        );
    }
}