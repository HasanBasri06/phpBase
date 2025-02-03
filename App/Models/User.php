<?php 

namespace App\Models;

class User extends Model {
    protected $table = "users";
    public function allUsers() {
        $sql = "SELECT * FROM " . $this->table;
        $qry = $this->db->prepare($sql);
        $qry->execute();

        return $qry->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function userDetail(int $id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $qry = $this->db->prepare($sql);
        $qry->bindValue(':id', $id);
        $qry->execute();
        
        return $qry->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $qry = $this->db->prepare($sql);
        $qry->bindValue(':email', $email);
        $qry->execute();
        
        return $qry->fetch(\PDO::FETCH_ASSOC);
    }

    public function save($name, $email, $password) {
        $hasPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . $this->table . " (name, email, password) VALUES (:name, :email, :password)";
        $qry = $this->db->prepare($sql);
        $qry->bindValue(':name', $name);
        $qry->bindValue(':email', $email);
        $qry->bindValue(':password', $hasPassword);
        $qry->execute();

        return true;
    }

    public function updatePasswordByAuthEmail($password) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE " . $this->table . " SET password = :password WHERE email = :email";
        $qry = $this->db->prepare($sql);
        $qry->bindValue(':password', $hashPassword);
        $qry->bindValue(':email', auth()['email']);
        $qry->execute();

        return true;
    }
}