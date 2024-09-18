<?php
namespace Src\App\Controllers\Upload;

use Src\App\Models\Upload\UploadModel;
use Src\App\Views;

class UploadController
{

          public function load_upload_page(string $path = "upload/UploadView", array $data = []): Views
          {
                    return Views::make($path, $data);
          }
          public function upload_video()
          {

                    $title = filter_input(INPUT_POST, 'videoTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $description = filter_input(INPUT_POST, 'videoDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $category = filter_input(INPUT_POST, 'videoCategory', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $tags = filter_input(INPUT_POST, 'videoTags', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $isPaid = filter_input(INPUT_POST, 'isPaid', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 1 : 0;
                    $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    // var_dump($_FILES);
                    // exit();
                    $uploadModel = new UploadModel();

                    $errors = $uploadModel->validateVideoUploadInputs($title, $description, $category, $tags);


                    if (!empty($errors)) {
                              return $this->load_upload_page(data: $errors);
                    }

          }
}