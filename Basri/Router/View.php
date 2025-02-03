<?php 

namespace Basri\Router;

use Config;
use Pug\Pug;

class View {
    private static $pug;
    
    public function __construct() {
        self::$pug = new Pug([
            'cache' => storage_path() . '/views/',
            'pretty' => true,
        ]);
    }
    
    public static function make($name, $data = []) {
        // $_SESSION['error']'ı doğru şekilde kontrol et ve hata mesajlarını şablona aktarmayı unutma
        $data = array_merge($data, [
            'asset' => public_path(),
            'csrf' => $_SESSION['CSRF_TOKEN'],
            'error' => isset($_SESSION['error']) ? $_SESSION['error'] : [],
            'success' => isset($_SESSION['success']) ? $_SESSION['success'] : []
        ]);
    
        $route = Config::view()['path'] . '/' . $name . ".pug";
        $pug = new Pug([
            'pretty' => true,
            'cache' => storage_path() . '/views/',
        ]);
    
        // Render işlemi
        echo $pug->renderFile($route, $data);
    
        // Hata mesajlarını gösterdikten sonra temizleyelim
        unset($_SESSION['error']);
        unset($_SESSION['success']);
    
        die;
    }    
}