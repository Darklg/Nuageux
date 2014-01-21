<?php

/**
 * Parse a directory
 *
 * @param string $base_folder    Base folder for our assets
 * @param string $new_dir        Dir to parse
 * @return object
 */
class mDir {
    function __construct( $base_folder, $new_dir ) {
        $this->base_folder = $base_folder;
        $this->folder = '';
        $dir = str_replace( array( '..' ), '', $new_dir );
        $dir = str_replace( array( '//' ), '/', $dir );
        if ( substr( $dir, -1 ) != '/' ) {
            $dir .= '/';
        }
        if ( is_dir( $this->base_folder . $dir ) ) {
            $this->folder = $dir;
        }
    }

    public function getCurrentFolder() {
        return $this->base_folder . $this->folder;
    }

    public function getCurrentFolderName() {
        $folderName = $this->removeTrailingSlash( $this->getCurrentFolder() );
        $folderParts = explode( '/', $folderName );
        return array_pop( $folderParts );
    }

    public function getBaseCurrentFolder() {
        $currentFolder = $this->getCurrentFolder();
        return $this->folder;
    }

    public function getCurrentFolderFiles() {
        $current_folder = $this->getCurrentFolder();
        $items = glob( $current_folder . '*' );
        $mItems = array();
        foreach ( $items as $item ) {
            $itemName = str_replace( $current_folder, '', $item );
            $mFile = new mFile( $this->folder, $itemName );
            if ( $mFile->ok ) {
                $mItems[] = $mFile;
            }
        }
        return $mItems;
    }

    public function getTopLink() {
        $topLink = false;

        $base_current_folder =  $this->getCurrentFolder();
        $current_folder = $this->removeTrailingSlash( $base_current_folder );
        if ( in_array( $this->base_folder, array( $current_folder, $base_current_folder ) ) ) {
            return false;
        }
        $folder_name = $this->getCurrentFolderName();
        $folder_basename = '/' . $folder_name;
        $folder_basename_length = strlen( $folder_basename );
        if ( substr( $current_folder, 0 - $folder_basename_length ) == $folder_basename ) {
            $topLink = substr( $current_folder, 0, 0 - $folder_basename_length );
            $topLink = str_replace( $this->base_folder, '', $topLink );
        }

        $displayTopLink = BASE_URL;
        if ( !empty( $topLink ) ) {
            $displayTopLink = BASE_URL . '?dir='.$topLink;
        }
        return $displayTopLink;
    }

    public function getBreadcrumbsParts() {
        $dir_origin = $this->removeTrailingSlash( $this->folder );
        $dir_origin_parts = explode( '/', $dir_origin );
        $parts = array();
        $path = '';
        foreach ( $dir_origin_parts as $part ) {
            if ( !empty( $part ) ) {
                $path .= '/' . $part;
                $parts[] = array(
                    'name' => $part,
                    'link' => BASE_URL . '?dir='.$path,
                    'path' => $path
                );
            }
        }
        return $parts;
    }

    // Utilities
    public function removeTrailingSlash( $string ) {
        if ( substr( $string, -1 ) == '/' ) {
            $string = substr( $string, 0, -1 );
        }
        return $string;
    }
}