<?php 

namespace Basri\Storage;

use Config;

class Storage {
    public static function putFile($file) {
        $name = storage_path().'/app/';

        if (!file_exists($name)) {
            mkdir($name);
        }

        $fileName = $name . '/' . $file['name'];
        move_uploaded_file($file['tmp_name'], $fileName);            
    } 

    
    public static function putFileAs($file, $storageName, $folder = '') {
        $name = storage_path().'/app/'.$folder;

        if (!file_exists($name)) {
            mkdir($name, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $name . '/app/' . $storageName.".".$extension;
        move_uploaded_file($file['tmp_name'], $fileName); 
    } 
}