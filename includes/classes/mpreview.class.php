<?php

/**
 * Preview a file
 *
 * @param string  $base_folder Base folder for our assets
 * @param object  $mFile       mFile object to preview
 * @return void
 */
class mPreview {
    function __construct( $base_folder, $mFile ) {
        $this->base_folder = $base_folder;
        $this->mFile = $mFile;
    }

    public function getTextContent( ) {
        $content = file_get_contents( $this->mFile->itemPath );
        $content = $this->filterTextContent( $content );
        return $content;
    }

    public function filterTextContent( $content ) {
        return htmlentities( $content );
    }

    public function getPreviewHTML( ) {
        $html = '';
        if ( $this->mFile === false ) {
            return;
        }
        $link = ASSETS_FOLDER . urldecode( $this->mFile->getLink() );
        switch ( $this->mFile->getType() ) {
        case 'txt' :
            $html = '<textarea>'.$this->getTextContent().'</textarea>';
            break;
        case 'jpg':
        case 'gif':
            $html = '<img src="'. $link.'" alt="" />';
            break;
        default :
        }
        return $html;
    }

}
