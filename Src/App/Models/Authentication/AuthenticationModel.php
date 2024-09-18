<?php
namespace Src\App\Models\Authentication;
use Src\App\Modle;

class AuthenticationModel extends Modle
{
    public function login(string $username, string $email, string $password)
    {
        try {
            $stmt = $this->db->prepare("
                                  INSERT INTO users (username, email, password, created_at)
                                  VALUES (:username, :email, :password, NOW())
                              ");
            $stmt->execute([
                "username" => $username,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            // Handle or log PDOException
            throw new \PDOException($e->getMessage());
        }

    }
    public function authenticate(string $email, string $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch();
            if (!$row) {
                throw new \Exception("User not found");
            }
            if (!password_verify($password, $row['password'])) {
                throw new \Exception("Password is incorrect");
            }
            return $row;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
