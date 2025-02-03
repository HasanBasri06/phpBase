<?php 

namespace App\Controllers;

use App\Models\User;
use Basri\Router\View;

class HomeController {
    public function loginPage() {
        $this->alreadyAuthUser();
        return View::make('login');
    }
    public function authUser() {
        $email = $_POST['email'];     
        $password = $_POST['password'];
        $csrf = (int) $_POST['csrf_token'];

        // csrf kontrolü yapıldı
        if ($csrf !== $_SESSION['CSRF_TOKEN']) {
            throw new \Exception("419 Hata");
        }
        
        // validatasyon yapıldı
        if (is_null($email) || is_null($password)) {
            $_SESSION['error'] = "Lütfen boş alan bırakmayınız";
            redirect_back();die;
        }

        $user = (new User())->getUserByEmail($email);

        // emaile göre kullanıcı var mı
        if (!$user) {
            $_SESSION['error'] = "Kullanıcı bulunamadı";
            redirect_back();die;
        }

        // şifre kontrolü yapıldı
        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Kullanıcı bulunamadı";
            redirect_back();die;
        }

        $_SESSION['auth'] = $user;
        redirect('/users/dashboard');
        exit;  
    }

    public function dashboardPage() {
        // eğer kullanıcı auth değil ise geri yönlendir
        if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
            redirect('/login');
        }

        View::make('dashboard', ['auth' => auth()]);
    }
    public function logout() {
        unset($_SESSION['auth']);
        redirect('login');
    }
    public function registerPage() {
        $this->alreadyAuthUser();
        View::make('register');
    }
    public function registerStore() {
        $name = $_POST['name'];     
        $email = $_POST['email'];     
        $password = $_POST['password'];
        $passwordConfirm = $_POST['password_confirm'];
        $csrf = (int) $_POST['csrf_token'];

        // csrf kontrolü yapıldı
        if ($csrf !== $_SESSION['CSRF_TOKEN']) {
            throw new \Exception("419 Hata");
        }

        // validatasyon yapıldı
        if (
            is_null($email) || 
            is_null($password) || 
            is_null($passwordConfirm) || 
            is_null($name)
        ) {
            $_SESSION['error'] = "Lütfen boş alan bırakmayınız";
            redirect_back();die;
        }

        // şifre aynı mı diye kontrol edildi
        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = "Şifreler uyuşmuyor";
            redirect_back();die;
        }

        $alreadyUser = (new User())->getUserByEmail($email);

        if ($alreadyUser) {
            $_SESSION['error'] = "Bu emaile ait kullanıcı daha önce kayıt olmuştur.";
            redirect_back();die;    
        }

        (new User())->save($name, $email, $password);
        
        $_SESSION['success'] = "Başarılı bir şekilde kayıt olundu.";
        redirect('/login');die; 
    }

    /**
     * 
     * Eğer kullanıcı auth ise ['login', 'register'] sayfalarına giriş gereksiz 
     * olsuğundan direk dashbord sayfasına yönlendiriyoruz
     * 
     */
    private function alreadyAuthUser() {
        if (isset($_SESSION['auth'])) {
            redirect('/users/dashboard');
        }
    }

    public function passwordChange() {
        View::make('password-change');
    }
    public function storePasswordChange() {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $newPasswordAgain = $_POST['new_password_again'];
        $csrf = $_SESSION['CSRF_TOKEN'];

        // csrf kontrolü yapıldı
        if ($csrf !== $_SESSION['CSRF_TOKEN']) {
            throw new \Exception("419 Hata");
        }

        $user = (new User())->getUserByEmail(auth()['email']);
        
        if (!password_verify($oldPassword, $user['password'])) {
            $_SESSION['error'] = "Eski şifre geçersiz";
            redirect_back();die;
        }

        if ($newPassword !== $newPasswordAgain) {
            $_SESSION['error'] = "Yeni şifreler uyuşmuyor";
            redirect_back();die;
        }

        if ($newPassword == $oldPassword) {
            $_SESSION['error'] = "Yeni şifre, eski şifre ile aynı olmamalı";
            redirect_back();die;
        }

        (new User())->updatePasswordByAuthEmail($newPassword); 
        $_SESSION['success'] = "Şifre başarılı bir şekilde değiştirildi";
        unset($_SESSION['auth']);
        redirect('/login');
    }
}