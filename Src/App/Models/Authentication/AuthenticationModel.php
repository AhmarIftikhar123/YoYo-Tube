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
    public function authenticate(string $email, ?string $password = null)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch();
            if (!$row) {
                throw new \Exception("User not found");
            }
            if ($row['is_blocked']) {
                $this->rm_session_cookies();
                throw new \Exception("User is not active or Blocked by the Admin");
            }
            if (!$password) {
                return $row;
            }
            if (!password_verify($password, $row['password'])) {
                throw new \Exception("Password is incorrect");
            }
            return $row;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function rm_session_cookies()
    {
        session_destroy();
        foreach ($_COOKIE as $cookie_name => $cookie_value) {
            setcookie($cookie_name, '', time() - 3600, '/');
        }
    }

    public function store_user_info(int|string $user_id, string $user_name)
    {
        $token = bin2hex(random_bytes(32));
        $this->store_data_in_cookie($user_id, $token, $user_name);

        $sql = "INSERT INTO persistent_logins (user_id, token, expires_at) VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL 1 WEEK)) ON DUPLICATE KEY UPDATE
        token = VALUES(token),
        expires_at = DATE_ADD(NOW(), INTERVAL 1 WEEK)";

        $stmt = $this->db->prepare($sql);

        $is_exeuted = $stmt->execute(['user_id' => $user_id, 'token' => $token]);

        return $is_exeuted;
    }

    private function store_data_in_cookie(string $user_id, string $token, string $user_name)
    {
        setcookie('user_id', $user_id, time() + 86400, '/');
        setcookie('token', $token, time() + 86400, '/');
        setcookie('user_name', $user_name, time() + 86400, '/');
    }

    public function store_profile_img($user_id, $profile_img)
    {
        $stmt = $this->db->prepare("UPDATE users SET profile_img = :profile_img WHERE id = :user_id");
        try {

            return $stmt->execute(['profile_img' => $profile_img, 'user_id' => $user_id,]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function google_login(string $username, string $email, string $profile_img)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, email,created_at,profile_img) VALUES (:username, :email, NOW() ,:profile_img)");
            $stmt->execute([
                "username" => $username,
                "email" => $email,
                "profile_img" => $profile_img
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            // Handle or log PDOException
            throw $e;
        }
    }

    public function is_user_already_registered(string $email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch();
            return $row ? $row : false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}