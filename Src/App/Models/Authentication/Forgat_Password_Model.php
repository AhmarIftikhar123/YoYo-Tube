<?php
namespace Src\App\Models\Authentication;
use Src\App\Modle;

class Forgat_Password_Model extends Modle
{
          protected $is_Email_Found;

          public function findByEmail(string $email): mixed
          {
                    // Prepare SQL statement
                    $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');

                    $stmt->bindParam(':email', $email);

                    // Execute the query
                    $stmt->execute();

                    // Fetch the user as an object (or return false if no user found)
                    $user = $stmt->fetch();
                    // If a user is found, return the user object; otherwise, return null
                    return $user ? $user["email"] : null;
          }

          public function storeResetToken(string $email, string $token): bool
          {
                    // SQL query to insert or update the password reset token
                    $sql = "INSERT INTO password_resets (email, token, created_at)
                    VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 DAY))
                    ON DUPLICATE KEY UPDATE
                    token = VALUES(token),
                    created_at = DATE_ADD(NOW(), INTERVAL 1 DAY)";

                    // Prepare the SQL statement
                    $stmt = $this->db->prepare($sql);

                    // Bind the parameters
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':token', $token);

                    // Execute the statement and return true if successful
                    $stmt->execute();
                    return true;
          }


          public function validateToken(string $token): bool
          {
                    $stmt = $this->db->prepare("SELECT token, created_at FROM password_resets WHERE token = :token");
                    $stmt->execute(['token' => $token]);
                    $row = $stmt->fetch();
                    if ($row && strtotime($row['created_at']) + 86400 > time()) {
                              return true;
                    }
                    return false;
          }

          public function storeNewPassword(string $email, string $password): bool
          {
                    $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE email = :email");
                    $stmt->execute(['password' => password_hash($password, PASSWORD_DEFAULT), 'email' => $email]);
                    return true;
          }
}

