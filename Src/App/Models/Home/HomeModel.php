<?php
namespace Src\App\Models\Home;
use Src\App\Modle;
class HomeModel extends Modle
{
    public function get_current_post_info(int $offset, int $limit = 8, string $tag = "action"): array
    {
        $sql = "
        SELECT videos.*, users.username 
        FROM videos 
        JOIN users ON videos.user_id = users.id
        WHERE JSON_CONTAINS(tags, :tag) 
        ORDER BY videos.created_at DESC 
        LIMIT :offset, :limit
    ";

        try {
            $stmt = $this->db->prepare($sql);

            // Encode the tag as a JSON array
            $tagParam = json_encode([$tag]);
            $stmt->bindParam(':tag', $tagParam);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);

            $stmt->execute();
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