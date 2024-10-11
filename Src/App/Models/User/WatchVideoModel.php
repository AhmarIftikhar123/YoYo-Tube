<?php
namespace Src\App\Models\User;
use Src\App\Modle;
class WatchVideoModel extends Modle
{
    public function get_current_latest_video_info($data)
    {
        if (!static::$user_registered) {
            $this->redirect_user_to_login();
        }
        try {
            $this->db->beginTransaction();
            $current_video_info = $this->get_current_video_info($data);
            $latest_videos_info = $this->get_lates_videos();
            $this->db->commit();
            return ['current_video_info' => $current_video_info, 'latest_videos_info' => $latest_videos_info];
        } catch (\PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }

    }
    public function get_current_video_info($data)
    {
        if (!static::$user_registered) {
            $this->redirect_user_to_login();
        }
        try {
            $sql = "SELECT * FROM videos WHERE id = :video_id AND is_paid = :is_paid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':video_id', $data['video_id']);
            $stmt->bindParam(':is_paid', $data['is_paid']);
            $stmt->execute();
            $result = $stmt->fetch();
            return !empty($result) ? $result : throw new \Exception("Video not found");
        } catch (\PDOException $e) {
            throw $e;
        }
    }
    public function get_lates_videos()
    {
        try {
            $sql = "SELECT * FROM videos ORDER BY created_at DESC LIMIT 6";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw $e;
        }
    }
    public function is_payment_history_exist($user_id, $video_id)
    {
        try {
            $sql = "SELECT * FROM payments WHERE user_id = :user_id AND video_id = :video_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':video_id', $video_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            throw $e;
        }
    }
    public function is_video_owner($video_info, $appUser_id)
    {
        $sql = "SELECT user_id FROM videos WHERE id = :video_id AND user_id = :user_id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':video_id', $video_info['video_id']);
            $stmt->bindParam(':user_id', $video_info['user_id']);
            $stmt->execute();
            $user_id = $stmt->fetch();
            return $user_id == $appUser_id ?? $_COOKIE['user_id'];
        } catch (\PDOException $e) {
            throw $e;
        }
    }
    public function format_like_post_data(array $data)
    {
        return [
            "video_id" => filter_input(INPUT_POST, 'video_id', FILTER_SANITIZE_NUMBER_INT),
            "user_id" => $this->get_user_id(),
            "like_status" => filter_input(INPUT_POST, 'like_status', FILTER_SANITIZE_NUMBER_INT),
            "action" => filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ];
    }
    public function format_comment_post_data(array $data)
    {
        return [
            "video_id" => filter_input(INPUT_POST, 'video_id', FILTER_SANITIZE_NUMBER_INT),
            "user_id" => $this->get_user_id(),
            "comment" => filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ];
    }
    public function like_dislike_video(array $likes_Info)
    {
        if (!static::$user_registered) {
            $this->redirect_user_to_login();
        }

        // First, check if the user has already liked or disliked the video
        $checkSql = "SELECT id FROM video_likes_dislikes WHERE user_id = :user_id AND video_id = :video_id";
        $stmtCheck = $this->db->prepare($checkSql);
        $stmtCheck->execute([
            "user_id" => $likes_Info['user_id'],
            "video_id" => $likes_Info['video_id']
        ]);

        $existingEntry = $stmtCheck->fetch();

        // Determine the SQL action to perform
        if ($existingEntry) {
            // If an entry exists, we can either UPDATE or DELETE
            $sql = match ($likes_Info['action']) {
                "INSERT" => "UPDATE video_likes_dislikes SET is_liked = :is_liked WHERE user_id = :user_id AND video_id = :video_id",
                "DELETE" => "DELETE FROM video_likes_dislikes WHERE user_id = :user_id AND video_id = :video_id",
                default => throw new \Exception("Invalid like status"),
            };
        } else {
            // No existing entry, only INSERT is valid
            if ($likes_Info['action'] === "INSERT") {
                $sql = "INSERT INTO video_likes_dislikes (user_id, video_id, is_liked) VALUES (:user_id, :video_id, :is_liked)";
            } else {
                throw new \Exception("Cannot perform DELETE when no entry exists");
            }
        }

        try {
            $stmt = $this->db->prepare($sql);

            // Bind parameters correctly based on the action
            $params = [
                "user_id" => $likes_Info['user_id'],
                "video_id" => $likes_Info['video_id'],
            ];

            // Add is_liked only for INSERT and UPDATE
            if ($likes_Info['action'] === "INSERT" || $likes_Info['action'] === "UPDATE") {
                $params["is_liked"] = $likes_Info['like_status'];
            }

            $stmt->execute($params);

            return $stmt->rowCount() ?? 0;
        } catch (\PDOException $e) {
            throw $e;
        }
    }
    public function add_video_comments(array $data)
    {
        if (!static::$user_registered) {
            $this->redirect_user_to_login();
        }
        $sql = "INSERT INTO comments (user_id, video_id, comment) VALUES (:user_id, :video_id, :comment)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':video_id', $data['video_id']);
            $stmt->bindParam(':comment', $data['comment']);
            $stmt->execute();
            return $stmt->rowCount() > 0 ? true : false;
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}