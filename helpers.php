<?php 

function storage_path() {
    return __DIR__ . '/storage/';
}

function asset($value) {
    return __DIR__ . '/public/';
}

function public_path() {
    return '/public/';
}

function redirect_back() {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function redirect($path) {
    header('Location: '. $path);
}

function ddd($items) {
    echo "<pre style='background-color: #020617; color: #64748b; width: max-content; padding: 10px; font-weight: 600; line-height: 1.5'>";
        var_dump($items);
    echo "</pre>";
    die;
}

function auth() {
    return $_SESSION['auth'] ?? false;
}