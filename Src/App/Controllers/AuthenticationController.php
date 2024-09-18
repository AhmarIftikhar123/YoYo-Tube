<?php
namespace Src\App\Controllers;

use Src\App\Models\Authentication\AuthenticationModel;
use Src\App\Views;

class AuthenticationController
{

          public function load_Authentication_Page(string $path = "Authentication/AuthenticationView", array $data = []): Views
          {
                    return Views::make($path, $data);
          }


          public function register(): Views
          {
                    $inputs = [
                              'username' => filter_input(INPUT_POST, 'username'),
                              'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
                              'password' => filter_input(INPUT_POST, 'password'),
                              'confirm_password' => filter_input(INPUT_POST, 'confirm_password'),
                    ];

                    $errors = $this->validateRegistrationInputs($inputs);
                    if (!empty($errors)) {
                              return $this->load_Authentication_Page("Authentication/AuthenticationView", [
                                        'usernameError' => $errors['username'] ?? '',
                                        'emailError' => $errors['email'] ?? '',
                                        'passwordError' => $errors['password'] ?? '',
                                        'confirm_passwordError' => $errors['confirm_password'] ?? '',
                                        "request_uri" => "/auth/register"
                              ]);
                    }
                    $authentication_model = new AuthenticationModel();
                    $last_inserted_id = $authentication_model->login(
                              $inputs['username'],
                              $inputs['email'],
                              $inputs['password']
                    );

                    if ($last_inserted_id) {
                              setcookie("user_id", $last_inserted_id, time() + (86400 * 30), "/");
                              return $this->load_Authentication_Page("Authentication/Registered_Sussfully", [
                                        'username' => $inputs['username'],
                                        'email' => $inputs['email'],
                                        'password' => $inputs['password'],
                              ]);
                    }
          }


          private function validateRegistrationInputs(array $inputs): array
          {
                    $errors = [];
                    if (empty($inputs['username'])) {
                              $errors['username'] = 'Username is required';
                    }

                    if (empty($inputs['email'])) {
                              $errors['email'] = 'Email is required';
                    }

                    if (empty($inputs['password'])) {
                              $errors['password'] = 'Password is required';
                    }

                    if (empty($inputs['confirm_password'])) {
                              $errors['confirm_password'] = 'Confirm password is required';
                    }
                    return $errors;
          }

          public function login(): Views
          {
                    $errors = [];

                    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                    $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES);

                    // Call validation method to check for errors
                    $errors = $this->validateLogin($email, $password);

                    // If there are errors, load the view with errors
                    if (!empty($errors)) {
                              return $this->load_Authentication_Page('Authentication/AuthenticationView', ["errors" => $errors]);
                    }

                    $authentication_model = new AuthenticationModel();
                    $isAuthenticated = $authentication_model->authenticate($email, $password);

                    if ($isAuthenticated) {
                              setcookie("user_id", $isAuthenticated["id"], time() + (86400 * 30), "/");
                              return $this->load_Authentication_Page('Authentication/Login_Successful_View', [
                                        "email" => $email,
                                        "password" => $isAuthenticated['password'],
                              ]);
                    } else {
                              header("HTTP/1.0 401 Unauthorized");
                              http_response_code(401);
                              return $this->load_Authentication_Page('Authentication/AuthenticationView', [
                                        "errors" => ["email" => "Invalid email or password.", "password" => "Invalid email or password."],
                              ]);
                    }
          }

          private function validateLogin($email, $password)
          {
                    // Initialize an empty errors array
                    $errors = [];

                    // Check if email is empty or invalid
                    if (empty($email)) {
                              $errors['email'] = 'Email is required.';
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                              $errors['email'] = 'Invalid email format.';
                    }

                    // Check if password is empty
                    if (empty($password)) {
                              $errors['password'] = 'Password is required.';
                    }

                    return $errors;
          }
}


