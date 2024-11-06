<?php
namespace Src\App\Models\Upload;
use Exception;
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
            if ($key === "price" && is_float($value || is_int($value))) {
                $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            }
        }
        // Ensure that 'isPaid' is set to 0 if not present in the post data
        if (!array_key_exists('isPaid', $postData)) {
            $sanitizedData['isPaid'] = 0;
        }
        if (!array_key_exists('price', $postData) || !is_numeric($sanitizedData['price'])) {
            $sanitizedData['price'] = "0";
        }
        return $sanitizedData;
    }

    public function validateVideoUploadInputs($title, $description, $tags): array
    {

        $errors = [];

        if (empty($title)) {
            $errors['videoTitleError'] = 'Title is required';
        } elseif (strlen($title) < 40) {
            $errors['videoTitleError'] = 'Title should be at least 40 words';
        }

        if (empty($description)) {
            $errors['videoDescriptionError'] = 'Description is required';
        }

        if (strlen($description) < 100) {
            $errors['videoDescriptionError'] = 'Description should be at least 100 words';
        }

        if (strlen($title) < 20) {
            $errors['videoTitleError'] = 'Title should be at least 20 words';
        }

        if (empty($tags)) {
            $errors['videoTagsError'] = 'Tags are required';
        } elseif (count(explode(",", $tags)) < 3) {
            $errors['videoTagsError'] = "Please enter at least 3 tags.";
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
                "uploadError" => "Video size should be less than 60mb"
            ];
        }
        return [];
    }

    public function upload_video(string $videoName, string $videoTmpName)
    {
        // assume userName is "Ahmar"
        if (!session_id()) {
            session_start();
        }
        $userName = $_SESSION["username"];
        if (empty($userName)) {
            error_log("Username not found we redirecting to authentication page");
            echo "<script>settimeout(() => { window.location.href = '/authentication'; }, 2000); </script>";
            die();
        }
        $main_dir = STORAGE_DIR . "/" . explode(" ", $userName)[0];

        $sub_dir = $main_dir . "/" . explode(".", $videoName)[0];

        // string(13) "storage/Ahmar"
        // string(48) "storage/Ahmar/Dharia-Sugar-and-Brownies-(Lyrics)" string(14)
        // string(87) "storage/Ahmar/Dharia-Sugar-and-Brownies-(Lyrics)/Dharia-Sugar-and-Brownies-(Lyrics).mp4"
        // "/tmp/php4dZqSY"

        if (!is_dir($sub_dir)) {
            if (!mkdir($sub_dir, 755, true)) {
                error_log("Failed to create directory: " . $sub_dir);
                die();
            }
        }

        $videoDestination = $sub_dir . "/" . $videoName;

        $thumbnailFile_path = $this->gen_thumbnail_and_store($videoTmpName, $sub_dir, $videoName);

        if (move_uploaded_file($videoTmpName, $videoDestination)) {
            session_write_close();
            return [
                "vidoe_destination" => $videoDestination,
                "thumbnail_path" => $thumbnailFile_path
            ];
        }
        return [
            'uploadError' => 'Failed to upload video'
        ];
    }



    public function gen_thumbnail_and_store(string $inputFile, string $files_destination, string $videoName)
    {
        ini_set('max_execution_time', 300); // Set to 5 minutes
        // Sanitize video name
        $videoName = explode(".", $videoName)[0];

        // Paths for output files
        $thumbnailFile = $files_destination . '/' . $videoName . '.jpg';

        // FFmpeg command template
        $ffmpegCommand = 'ffmpeg -i %s -ss 00:00:05 -vframes 1 %s 2>&1';

        if (file_exists($thumbnailFile)) {
            unlink($thumbnailFile);
        }
        // Function to execute a command and handle errors
        function executeCommand(string $command): void
        {
            try {
                exec($command, $output, $returnVar);
                if ($returnVar !== 0) {
                    throw new Exception("Command failed with exit code $returnVar");
                }
            } catch (\Throwable $e) {
                echo "Error executing command: $command\n";
                echo "Output: " . implode("\n", $output) . "\n";
                throw $e;
            }
        }

        // Capture thumbnail at 5 seconds
        $thumbnailCommand = sprintf($ffmpegCommand, escapeshellarg($inputFile), escapeshellarg($thumbnailFile));
        executeCommand($thumbnailCommand);
        return $thumbnailFile;
    }


    public function add_video_to_database(array $video_data)
    {
        try {
            $stmt = $this->db->prepare(
                "
                            INSERT INTO videos (user_id, title, description, file_path, category, tags, is_paid, created_at, updated_at,thumbnail_path,price)
                            VALUES (
                                :user_id,
                                :title,
                                :description,
                                :file_path,
                                :category,
                                :tags,
                                :is_paid,
                                CURRENT_TIMESTAMP, 
                                CURRENT_TIMESTAMP,
                                :thumbnail_path,
                                :price
                            )
                            "
            );

            // assume user id is 1 
            $userId = static::$user_id;
            if (!$userId) {
                $this->redirect_user_to_login();
            }
            $isInserted = $stmt->execute([
                ':user_id' => $userId,
                ':title' => $video_data['title'],
                ':description' => $video_data['videoDescription'],
                ':file_path' => explode("/src", $video_data['file_path'])[1],
                ':category' => $video_data['category'],
                ':tags' => json_encode($video_data['videoTags']),
                ':is_paid' => $video_data['is_paid'],
                ':thumbnail_path' => explode("/src", $video_data['thumbnail_path'])[1],
                ':price' => $video_data['price']
            ]);
            return $isInserted ? $this->db->lastInsertId() : ["upload_video_error" => "Failed to upload video"];
        } catch (\Throwable $e) {
            return [
                'upload_video_error' => "Failed to upload video. Error: " . $e->getMessage()
            ];
        }
    }
}