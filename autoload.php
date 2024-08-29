<?php
spl_autoload_register( function( $class ) {
    $class_path = str_replace( "\\", "/", $class );
    $class_file = __DIR__ . "/src/" . $class_path . ".php";

    if( file_exists( $class_file ) ) {
        require_once( $class_file );
    }
} );
