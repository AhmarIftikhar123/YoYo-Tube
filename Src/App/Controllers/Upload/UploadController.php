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
                    $video = $_FILES['video'];

                    $uploadModel = new UploadModel();

                    /**
                     * @param array $post $_POST values
                     *
                     * @return array{
                     *     "videoTitle" => string,
                     *     "videoDescription" => string,
                     *     "videoTags" => string,
                     *     "videoCategory" => string,
                     *     "isPaid" => int
                     * }
                     */

                    $post_values = $uploadModel->getPostValues($_POST);
                    // For empty inputs handling
                    $errors = $uploadModel->validateVideoUploadInputs($post_values['videoTitle'], $post_values['videoDescription'], $post_values['videoTags']);

                    if (!empty($errors)) {
                              return $this->load_upload_page(data: $errors);
                    }

                    // return video information in array form
                    $video_info = $uploadModel->get_video_info($video);

                    $is_valid_video = $uploadModel->validate_video($video_info['type'], $video_info['size']);

                    // throws error if video is in invalid format or size
                    if (!empty($is_valid_video)) {
                              return $this->load_upload_page(data: $is_valid_video);
                    }
                    ;

                    $is_video_uploaded = $uploadModel->upload_video($video_info['name'], $video_info['tmp_name']);

                    if (is_array($is_video_uploaded)) {
                              return $this->load_upload_page(data: $is_video_uploaded);
                    }

                    /* -------- Upload upload Code Fininsh Here  --------*/

                    $video_data = [
                              'file_path' => $is_video_uploaded,
                              'title' => $post_values['videoTitle'],
                              'videoDescription' => $post_values['videoDescription'],
                              'videoTags' => $post_values['videoTags'],
                              "category" => $post_values['videoCategory'],
                              "is_paid" => $post_values['isPaid']
                    ];

                    $is_video_uploaded_success = $uploadModel->add_video_to_database($video_data);

                    if (is_string($is_video_uploaded_success)) {
                              return $this->load_upload_page("upload/UploadSuccessView", data: ["file_name" => $video_info['name'], "video_category" => $post_values['videoCategory']]);
                    } else {
                              return $this->load_upload_page(data: $is_video_uploaded_success);
                    }
          }
}