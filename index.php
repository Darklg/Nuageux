<?php

define( 'BASE_DIR', dirname( __FILE__ ) . '/'  );
include BASE_DIR . '/includes/header.php';

/* ----------------------------------------------------------
  View
---------------------------------------------------------- */

echo '<!DOCTYPE HTML>
<html lang="en-EN">
<head>
<meta charset="UTF-8" />
<title>Nuageux</title>
</head>
<body>
<h1>Nuageux</h1>';

$parts = $mDir->getBreadcrumbsParts();
if ( !empty( $parts ) ) {
    echo '<div>';
    echo '<span><a href="'.BASE_URL.'">Home</a></span>';
    foreach ( $parts as $part ) {
        echo ' <span><a href="'.$part['link'].'">'.$part['name'].'</a></span>';
    }
    echo '</div>';
}
/* Top Links */
$mItems = $mDir->getCurrentFolderFiles();
$topLink = $mDir->getTopLink();

echo '<ul>';
if ( $topLink !== false ) {
    echo '<li><a href="'.$topLink.'">&uarr; Top</a></li>';
}
foreach ( $mItems as $mItem ) {
    $link = '?dir='.$mItem->getLink();
    if ( !$mItem->isDir() ) {
        $link = '?file='.$mItem->getLink();
    }
    echo '<li><a href="'.BASE_URL.$link.'">'.( $mItem->isDir() ? '[__] ' : '' ).$mItem->getName().'</a></li>';
}
echo '</ul>';

if ( $mFile !== false && $mFile->ok ) {
    $mPreview = new mPreview( BASE_FOLDER, $mFile );
    echo $mPreview->getPreviewHTML();
}

echo '</body></html>';
