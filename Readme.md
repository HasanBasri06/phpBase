## Genel Bakış

Proje PHP ile oluşturulmuş bir MVC (Model, View, Controller) tabanlı bir sistemdir. Kendi router sistemi olup PSR-7 sistemi ile 'controller' oluşturulmaktadır. Router sistemi ve diğer proje kodları basri klasörünün içinde oluşturulmuştur.

'App' klasörü ise içinde http isteklerini ve veritabanı işlemleri yapılmaktadır.

'views' klasörünün içinde ise oluşturulan ekran arayüzlerinin html sayfası vardır. Fakat bu klasörler .html yada .php değildir, bunun yerine .pug template'ni kullanmaktadır.

## Çalıştırma

```php -S localhost:8000``` ile projeyi başlatabilirsiniz. eğer 8000 portu başka bir yerde çalıştırılıyor ise değiştirebilirsiniz. örn; 8001

## Router 

``router/web.php`` sayfasında $router değişkeninden rota oluşturulmaktadır. Ve bu 3 farklı şekilde oluşturulabilir.

'<?php 

use App\Http\Controllers\HomeController;

'router->get("/", fn() => "Anasayfa")
$router->get("/", function() {
    return "Anasayfa";
})
$router->get("/", [HomeController::index, 'index']);
'