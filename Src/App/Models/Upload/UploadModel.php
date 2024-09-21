<?php
namespace Src\App\Models\Upload;
use Src\App\Modle;

class UploadModel extends Modle
{
    public function getPostValues($postData)
    {
        $sanitizedData = [];

        foreach ($postData as $key => $value) {
            // Sanitize each value based on its type
            if ($key === 'isPaid') {
                // Boolean value, convert to 1 or 0
                $sanitizedData[$key] = isset($value) && filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            } else {
                // Sanitize the rest of the values as strings
                $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        // Ensure that 'isPaid' is set to 0 if not present in the post data
        if (!array_key_exists('isPaid', $postData)) {
            $sanitizedData['isPaid'] = 0;
        }
        return $sanitizedData;
    }

    public function validateVideoUploadInputs($title, $description, $tags): array
    {

        $errors = [];

        if (empty($title)) {
            $errors['upload_title_error'] = 'Title is required';
        }

        if (empty($description)) {
            $errors['upload_description_error'] = 'Description is required';
        }

        if (strlen($description) < 100) {
            $errors['upload_description_error'] = 'Description should be at least 100 words';
        }

        if (strlen($title) < 20) {
            $errors['upload_title_error'] = 'Title should be at least 20 words';
        }

        if (empty($tags)) {
            $errors['upload_tags_error'] = 'Tags are required';
        }

        return $errors;
    }
    public function get_video_info(array $video): array
    {
        return [
            'name' => $video['name'],
            'type' => $video['type'],
            'size' => $video['size'],
            'tmp_name' => $video['tmp_name']
        ];

    }

    public function validate_video(string $video_type, string $videoSize): array
    {
        $allowedVideoTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/mkv'];

        if (!in_array($video_type, $allowedVideoTypes)) {
            return [
                'upload_video_error' => 'Only mp4, webm, mkv and ogg video types are allowed'
            ];
        }
        ;
        if ($videoSize > 600000000) {
            return [
                "upload_video_error" => "Video size should be less than 60mb"
            ];
        }
        return [];
    }

    public function upload_video(string $videoName, string $videoTmpName)
    {
        // assume userName is "Ahmar"
        $userName = "Ahmar";

        $storage_dir = STORAGE_DIR . "/" . $userName;

        if (!is_dir($storage_dir)) {
            mkdir($storage_dir, 755, true);
        }

        $videoDestination = $storage_dir . "/" . $videoName;

        if (move_uploaded_file($videoTmpName, $videoDestination)) {
            return $videoDestination;
        }
        return [
            'upload_video_error' => 'Failed to upload video'
        ];
    }
    public function add_video_to_database(array $video_data)
    {
        $stmt = $this->db->prepare(
            "
                        INSERT INTO videos (user_id, title, description, file_path, category, tags, is_paid, created_at, updated_at)
                        VALUES (
                            :user_id,
                            :title,
                            :description,
                            :file_path,
                            :category,
                            :tags,
                            :is_paid,
                            CURRENT_TIMESTAMP, 
                            CURRENT_TIMESTAMP
                        )
                        "
        );

        // assume user id is 1 
        $userId = 1;
        $isInserted = $stmt->execute([
            ':user_id' => $userId,
            ':title' => $video_data['title'],
            ':description' => $video_data['videoDescription'],
            ':file_path' => $video_data['file_path'],
            ':category' => $video_data['category'],
            ':tags' => json_encode($video_data['videoTags']),
            ':is_paid' => $video_data['is_paid']
        ]);

        return $isInserted ? $this->db->lastInsertId() : ["upload_video_error" => "Failed to upload video"];
    }
}