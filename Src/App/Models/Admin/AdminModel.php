<?php
namespace Src\App\Models\Admin;
use Src\App\Modle;
class AdminModel extends Modle
{
  public function get_all_posts(): array
  {
    $sql = "SELECT 
                              u.id,
                              u.username,
                              u.email,
                              u.role,
                              u.is_blocked,
                              COUNT(v.id) AS total_posts
                            FROM 
                              users u
                            LEFT JOIN 
                              videos v ON u.id = v.user_id
                            GROUP BY 
                              u.id, u.username, u.email, u.role, u.is_blocked;";
    $stmt = $this->db->prepare($sql);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (\Throwable $e) {
      die("Error: " . $e->getMessage());
    }
  }
  public function admin_action($user_id, $action)
  {
    $sql = match ($action) {
      "Block" => "UPDATE users SET is_blocked = 1 WHERE id = :user_id",
      "Un-Block" => "UPDATE users SET is_blocked = 0 WHERE id = :user_id",
      "Delete" => "DELETE FROM users WHERE id = :user_id",
    };
    try {
      $stmt = $this->db->prepare($sql);
      if ($stmt->execute(['user_id' => $user_id])) {
        return true;
      }
    } catch (\PDOException $e) {
      error_log($e->getMessage()); // Log the error message
      throw $e;
    }
  }
  public function get_user_posts(int $user_id): array
  {
    $sql = "SELECT * FROM videos WHERE user_id = :user_id";
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute(['user_id' => $user_id]);
      return $stmt->fetchAll();
    } catch (\PDOException $e) {
      throw $e;
    }
  }
}