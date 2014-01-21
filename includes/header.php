<?php

/* ----------------------------------------------------------
  Config
---------------------------------------------------------- */

define( 'ASSETS_FOLDER', 'files' );
define( 'BASE_FOLDER', BASE_DIR . '/' . ASSETS_FOLDER );
define( 'BASE_URL', '/Nuageux/' );

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );


/* ----------------------------------------------------------
  Classes
---------------------------------------------------------- */

include BASE_DIR . '/includes/classes/mfile.class.php';
include BASE_DIR . '/includes/classes/mdir.class.php';
include BASE_DIR . '/includes/classes/mpreview.class.php';

/* ----------------------------------------------------------
  Controller
---------------------------------------------------------- */

$this_folder =  '';
$dir_origin = '';
$mFile = false;
if ( isset( $_GET['dir'] ) ) {
    $dir_origin = $_GET['dir'];
}
else {
    $dir_origin = '';
    if ( isset( $_GET['file'] ) ) {
        $file_parts = explode( '/', $_GET['file'] );
        $file_name = array_pop( $file_parts );
        $dir_origin = implode( '/', $file_parts );
        $mFile = new mFile( $dir_origin . '/', $file_name );
    }
}

$mDir = new mDir( BASE_FOLDER, $dir_origin );