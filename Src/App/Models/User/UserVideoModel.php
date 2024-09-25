<?php
namespace Src\App\Models\User;
use Src\App\Modle;
class UserVideoModel extends Modle
{


          public function get_user_posts(int $user_id, int $offset, int $limit = 8, string $catogery = "action"): array
          {
                    $sql = "SELECT * FROM videos WHERE user_id = :user_id AND category = :category ORDER BY created_at DESC LIMIT :offset, :limit";
                    try {

                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['user_id' => $user_id, 'category' => $catogery, "offset" => $offset, "limit" => $limit]);
                              $row = $stmt->fetchAll();
                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }

          public function get_all_user_posts(int $user_id, bool|string $filter_type = false): array
          {
                    $sql = "SELECT * FROM videos WHERE user_id = :user_id";
                    if ($filter_type) {
                              $sql = "SELECT * FROM videos WHERE user_id = :user_id AND category = :category";
                    }
                    try {

                              $stmt = $this->db->prepare($sql);
                              if ($filter_type)
                                        $stmt->execute(['user_id' => $user_id, 'category' => $filter_type]);
                              else
                                        $stmt->execute(['user_id' => $user_id]);

                              $row = $stmt->fetchAll();
                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }
}