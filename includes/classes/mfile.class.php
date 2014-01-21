<?php

/**
 * Get file details
 *
 * @param string  $folder   Folder for our file
 * @param string  $itemName File name to get the details from
 * @return void
 */
class mFile {
    function __construct( $folder, $itemName ) {
        $item_full_path = BASE_FOLDER . $folder . $itemName;
        $this->ok = true;
        if ( !is_dir( $item_full_path ) && !file_exists( $item_full_path ) ) {
            $this->ok = false;
            return false;
        }
        $this->folderPath = $folder;
        $this->itemPath = $item_full_path;
        $this->getDetails();
    }

    function getDetails() {
        // File name
        $name = str_replace( array( BASE_FOLDER, $this->folderPath ), '', $this->itemPath );

        // Link
        $link = $this->folderPath . $name;

        // Type file
        $isDir = is_dir( $this->itemPath );
        if ( $isDir ) {
            $type = 'is_dir';
            $this->itemPath .= '/';
        }
        else {
            $type = pathinfo( $link, PATHINFO_EXTENSION );
        }

        $this->item = array(
            'name' => $name,
            'type' => $type,
            'link' => $link,
            'isdir' => $isDir
        );
    }

    // Getters
    public function getName() {
        return $this->item['name'];
    }

    public function gettype() {
        return $this->item['type'];
    }

    public function getLink() {
        return urlencode( $this->item['link'] );
    }

    // Tests
    public function isDir() {
        return $this->item['isdir'];
    }
}
