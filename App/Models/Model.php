<?php 

namespace App\Models;

class Model {
    protected $db;
    public function __construct() {
        try {
            $pdo = new \PDO("mysql:host=localhost;dbname=deneme", "basri", "Hasan54321%");
            $this->db = $pdo;
        } catch (\PDOException $th) {
            die($th->getMessage());
        }
    }
}