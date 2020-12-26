<?php

// Register widgets.
function electro_extensions_widgets_register() {
    if ( class_exists( 'Electro' ) ) {        
        include_once get_template_directory() . '/inc/widgets/class-electro-wc-catalog-orderby.php';
        register_widget( 'Electro_WC_Catalog_Orderby' );
    }
}

add_action( 'widgets_init', 'electro_extensions_widgets_register' );