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
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (\Throwable $e) {
      die("Error: " . $e->getMessage());
    }
  }
  public function get_posts($offset, $limit = 8): array
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
                              u.id, u.username, u.email, u.role, u.is_blocked
                            LIMIT :offset, :limit;";
    $stmt = $this->db->prepare($sql);
    try {
      $stmt->execute(["offset" => $offset, "limit" => $limit]);
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
  public function get_user_posts(int $user_id, int $offset, $limit = 8): array
  {
    $sql = "SELECT * FROM videos WHERE user_id = :user_id LIMIT :offset, :limit;";
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([':user_id' => $user_id, ":offset" => $offset, ":limit" => $limit]);
      return $stmt->fetchAll();
    } catch (\PDOException $e) {
      throw $e;
    }
  }
  public function get_all_user_posts($user_id)
  {
    $sql = "SELECT * FROM videos WHERE user_id = :user_id";
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute([':user_id' => $user_id]);
      return $stmt->fetchAll();
    } catch (\PDOException $e) {
      throw $e;
    }
  }
  public function update_video_visibility($action, $video_id)
  {
    $sql = match ($action) {
      "Block" => "UPDATE videos SET for_public = 0 , updated_at = NOW() WHERE id = :video_id",
      "Un-Block" => "UPDATE videos SET for_public = 1 , updated_at = NOW() WHERE id = :video_id",
      "delete" => "DELETE FROM videos WHERE id = :video_id",
    };
    try {
      $stmt = $this->db->prepare($sql);
      $stmt->execute(['video_id' => $video_id]);
      if ($stmt->rowCount() > 0 || $stmt->errorCode() == '00000') {
        return true;
      }
      return false;
    } catch (\PDOException $e) {
      throw $e;
    }
  }
  public function check_user_registered()
  {
    if (!session_id()) {
      session_start();
    }
    if (isset($_SESSION['user_id'])) {
      return true;
    }
    return false;
  }
  public function register_user(){
    echo "User not found. Redirecting to authentication page...";
    echo "<script>setTimeout(() => { window.location.href = '/authentication'; }, 2000);</script>";
    exit();
  }
}