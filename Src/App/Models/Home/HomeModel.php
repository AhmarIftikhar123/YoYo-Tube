<?php
namespace Src\App\Models\Home;
use Src\App\Modle;
class HomeModel extends Modle
{
          public function get_current_post_info(int $offset, int $limit = 8, string $catogery = "action"): array
          {
                    $sql = "SELECT * FROM videos WHERE category = :category ORDER BY created_at DESC LIMIT :offset, :limit";
                    try {

                              $stmt = $this->db->prepare($sql);
                              $stmt->execute(['category' => $catogery, "offset" => $offset, "limit" => $limit]);
                              $row = $stmt->fetchAll();
                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }
          public function get_all_posts_info($category = false): array
          {

                    $sql = $category 
                    ? "SELECT * FROM videos WHERE category = :category ORDER BY created_at DESC" 
                    : "SELECT * FROM videos ORDER BY created_at DESC";
                
                    try {
                              $stmt = $this->db->prepare($sql);
                              if ($category) {
                                        // Bind the category value securely
                                        $stmt->bindParam(':category', $category, \PDO::PARAM_STR);
                                    }
                              $stmt->execute();
                              $row = $stmt->fetchAll();
                              return $row;
                    } catch (\Throwable $e) {
                              die("Error: " . $e->getMessage());
                    }
          }
}