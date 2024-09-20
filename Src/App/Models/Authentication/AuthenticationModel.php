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

    public function store_user_info(int $user_id)
    {
        $token = bin2hex(random_bytes(32));
        $this->store_data_in_cookie($user_id, $token);

        $sql = "INSERT INTO persistent_logins (user_id, token, expires_at) VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL 1 WEEK)) ON DUPLICATE KEY UPDATE
        token = VALUES(token),
        expires_at = DATE_ADD(NOW(), INTERVAL 1 WEEK)";

        $stmt = $this->db->prepare($sql);

        $is_exeuted = $stmt->execute(['user_id' => $user_id, 'token' => $token]);

        return $is_exeuted;
    }

    private function store_data_in_cookie(string $user_id, string $token)
    {
        if (explode("?", $_SERVER["REQUEST_URI"])) {
            setcookie('user_id', $user_id, -1, '/');
            setcookie('token', $token, -1, '/');
        }
        if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['token'])) {
            setcookie('user_id', $user_id, time() + 86400, '/');
            setcookie('token', $token, time() + 86400, '/');
        }
    }
}