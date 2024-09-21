<?php
namespace Src\App\Models\User;
use Src\App\Modle;
class UserVideoModel extends Modle
{

          public function get_user_posts(int $user_id, int $offset = 0, int $limit = 8): array
          {
                    $sql = "SELECT * FROM videos WHERE user_id = :user_id LIMIT :offset, :limit";
                    try {

                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['user_id' => $user_id, "offset" => $offset, "limit" => $limit]);
                              $row = $stmt->fetchAll();
                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }
}