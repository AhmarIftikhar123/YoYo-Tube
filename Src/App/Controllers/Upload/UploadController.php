<?php
namespace Src\App\Controllers\Upload;

use Src\App\Models\Upload\UploadModel;
use Src\App\Views;

class UploadController
{
          private UploadModel $uploadModel;
          public function __construct()
          {
                    $this->uploadModel = new UploadModel();
          }

          public function load_upload_page(string $path = "upload/UploadView", array $data = []): Views
          {
                    if (!UploadModel::$user_registered) {
                              $this->uploadModel->redirect_user_to_login();
                    }

                    return Views::make($path, $data);
          }
          public function upload_video()
          {
                    try {
                              $video = $_FILES['video'];
                              if (empty($video['name'])) {
                                        echo json_encode(["success" => false, "message" => "No video was uploaded"]);
                                        exit;
                              }

                              $this->uploadModel = new UploadModel();

                              /**
                               * @param array $post_values $_POST values
                               *
                               * @return array{
                               *     "videoTitle" => string,
                               *     "videoDescription" => string,
                               *     "videoTags" => string,
                               *     "videoCategory" => string,
                               *     "isPaid" => int
                               * }
                               */
                              $post_values = $this->uploadModel->getPostValues($_POST);
                              // Validate inputs
                              $errors = $this->uploadModel->validateVideoUploadInputs($post_values['videoTitle'], $post_values['videoDescription'], $post_values['videoTags']);
                              if (!empty($errors)) {
                                        echo json_encode(["success" => false, "message" => $errors]);
                                        exit();
                              }

                              // Get video information
                              $video_info = $this->uploadModel->get_video_info($video);
                              $is_valid_video = $this->uploadModel->validate_video($video_info['type'], $video_info['size']);

                              if (!empty($is_valid_video)) {
                                        echo json_encode(["success" => false, "message" => $is_valid_video]);
                                        exit;
                              }

                              // Upload video
                              $is_video_uploaded = $this->uploadModel->upload_video($video_info['name'], $video_info['tmp_name']);
                              if (array_key_exists('uploadError', $is_video_uploaded)) {
                                        echo json_encode(["success" => false, "message" => $is_video_uploaded]);
                                        exit;
                              }

                              // Prepare video data
                              $video_data = [
                                        'file_path' => $is_video_uploaded['vidoe_destination'],
                                        "thumbnail_path" => $is_video_uploaded['thumbnail_path'],
                                        'title' => $post_values['videoTitle'],
                                        'videoDescription' => $post_values['videoDescription'],
                                        'videoTags' => explode(',',$post_values['videoTags']),
                                        "category" => $post_values['videoCategory'],
                                        "is_paid" => $post_values['isPaid'],
                                        "price" => $post_values['price'],
                              ];

                              // Add video to the database
                              $is_video_uploaded_success = $this->uploadModel->add_video_to_database($video_data);
                              header('Content-Type: application/json');
                              if (is_string($is_video_uploaded_success)) {
                                        echo json_encode([
                                                  "success" => true,
                                                  "message" => "Video Uploaded Successfully",
                                                  "file_name" => $video_info['name'],
                                                  "video_category" => $post_values['videoCategory']
                                        ]);
                              } else {
                                        echo json_encode([
                                                  "success" => false,
                                                  "message" => "Failed to Upload Video to the Database",
                                        ]);
                              }
                    } catch (\Exception $e) {
                              // Catch any error and return as JSON response
                              echo json_encode([
                                        "success" => false,
                                        "message" => "Error occurred: " . $e->getMessage()
                              ]);
                    }
          }

}