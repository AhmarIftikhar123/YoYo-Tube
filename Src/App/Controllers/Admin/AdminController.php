<?php
namespace Src\App\Controllers\Admin;
use Src\App\Models\Admin\AdminModel;
use Src\App\Views;
class AdminController
{
          protected AdminModel $adminModel;
          public function __construct()
          {
                    $this->adminModel = new AdminModel();
          }
          public function load_Dashboard(string $path = "admin/AdminView", array $data = []): Views
          {
                    $data['all_posts'] = $this->adminModel->get_all_posts();
                    return Views::make($path, $data);
          }

          public function admin_action()
          {
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
                    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
                    $username = filter_input(INPUT_GET, 'username',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $data = ["posts" => $this->adminModel->get_user_posts($user_id), "user_id" => $user_id , "username" => $username];
                    if (!empty($data['posts'])) {
                              return $this->load_Dashboard("admin/UserPostsView", $data);
                    }
          }
}