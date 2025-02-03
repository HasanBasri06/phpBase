<?php

class Config {
    public static function router() 
    {
        return [
            'errors' => [
                '404' => __DIR__ . '/Basri/Router/errors/404.html'
            ]
        ];
    } 

    public static function storage() 
    {
        return [
            'page' => __DIR__ . '/storage'
        ];
    } 
    
    public static function view() 
    {
        return [
            'path' => __DIR__ . '/views'
        ];
    } 
} 