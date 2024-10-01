<?php
namespace Src\App\Controllers\Admin;
use Src\App\Models\Admin\AdminModel;
use Src\App\Views;
class AdminController
{
          protected AdminModel $adminModel;
          protected $is_user_registered;
          public function __construct()
          {
                    $this->adminModel = new AdminModel();
                    $this->is_user_registered = $this->adminModel->check_user_registered();
          }
          public function load_Dashboard(string $path = "admin/AdminView", array $data = []): Views
          {
                    return Views::make($path, $data);
          }
          public function load_Admin_Dashboard()
          {
                    if (!$this->is_user_registered) {
                              $this->adminModel->register_user();
                    }
                    $get_offset = isset($_GET['page']) ? (int) filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT) : 0;
                    $offset = $get_offset === 1 || $get_offset === 0 ? 0 : ($get_offset - 1) * 8;
                    $data = ["posts" => $this->adminModel->get_posts($offset), "all_posts" => $this->adminModel->get_all_posts()];
                    return $this->load_Dashboard("admin/AdminView", $data);
          }

          public function update_user_status()
          {
                    if (!$this->is_user_registered) {
                              $this->adminModel->register_user();
                    }
                    if ($_SERVER['REQUEST_METHOD'] != "POST") {
                              echo json_encode(['success' => false, "message" => "Something went wrong"]);
                              exit();
                    } else {

                              $user_id = $_POST['user_id'];
                              $action = $_POST['action'];
                              header('Content-Type: application/json');
                              if ($this->adminModel->admin_action($user_id, $action)) {
                                        echo json_encode(['success' => true]);
                              } else {
                                        echo json_encode(['success' => false, "message" => "Something went wrong"]);
                              }
                    }
          }
          public function load_user_posts()
          {
                    if (!$this->is_user_registered) {
                              $this->adminModel->register_user();
                    }
                    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
                    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $get_offset = isset($_GET['page']) ? (int) filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT) : 0;

                    $offset = $get_offset === 1 || $get_offset === 0 ? 0 : ($get_offset - 1) * 8;
                    $data = [
                              "posts" => $this->adminModel->get_user_posts($user_id, $offset),
                              "all_posts" => $this->adminModel->get_all_user_posts($user_id),
                              "user_id" => $user_id,
                              "username" => $username
                    ];
                    if (!empty($data['posts'])) {
                              return $this->load_Dashboard("admin/UserPostsView", $data);
                    }
                    return $this->load_Dashboard("admin/UserPostsView", $data);
          }
          public function update_video_status()
          {
                    if (!$this->is_user_registered) {
                              $this->adminModel->register_user();
                    }
                    header('Content-Type: application/json');

                    if ($_SERVER['REQUEST_METHOD'] != "POST") {
                              echo json_encode([
                                        "success" => false,
                                        "message" => "Server Request Method is not Secure!"
                              ]);
                              exit();
                    } else {
                              // Sanitize input
                              $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                              $video_id = filter_input(INPUT_POST, "video_id", FILTER_SANITIZE_NUMBER_INT);

                              // Check if action or video_id is empty or invalid
                              if (empty($action) || empty($video_id)) {
                                        echo json_encode([
                                                  "success" => false,
                                                  "message" => "Invalid input data"
                                        ]);
                                        exit();
                              }

                              // Call model function to handle the action
                              if ($this->adminModel->update_video_visibility($action, $video_id)) {
                                        echo json_encode([
                                                  "success" => true
                                        ]);
                              } else {
                                        echo json_encode([
                                                  "success" => false,
                                                  "message" => "Something went wrong while updating the video status",
                                                  "video_id" => $video_id
                                        ]);
                              }
                    }

          }
}