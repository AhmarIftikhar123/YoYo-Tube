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
    public function is_video_owner($video_info , $appUser_id)
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
}