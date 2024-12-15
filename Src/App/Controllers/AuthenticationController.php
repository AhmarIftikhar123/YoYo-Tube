<?php
namespace Src\App\Controllers;

use Exception;
use Facebook\Facebook;
use Src\App\Models\Authentication\AuthenticationModel;
use Src\App\Views;
use Throwable;

class AuthenticationController
{
          protected $client;
          public function load_Authentication_Page(string $path = "Authentication/AuthenticationView", array $data = []): Views
          {
                    if (isset($_GET['code'])) {
                              $data = $this->handle_google_login();
                              if (is_array($data)) {
                                        header("Location: /home");
                                        exit;
                              }
                    } else {
                              $data['google_client_config'] = $this->google_client_config();
                    }
                    return Views::make($path, $data);
          }


          public function register()
          {
                    $inputs = [
                              'username' => filter_input(INPUT_POST, 'username'),
                              'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
                              'password' => filter_input(INPUT_POST, 'password'),
                              'confirm_password' => filter_input(INPUT_POST, 'confirm_password'),
                              'remember_me_registeration' => filter_input(INPUT_POST, 'remember_me_registeration', FILTER_VALIDATE_BOOL) ? 1 : 0,
                              "role" => filter_input(INPUT_POST, 'role') === "admin" ? 1 : 0
                    ];
                    if ($inputs['role'] === 1) {
                              throw new Exception("You can't register as Admin.Please contact the Website Owner for Admin access.");
                    }
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
                              $inputs['password'],
                              $inputs['role']
                    );

                    if ($last_inserted_id) {
                              // Store Cookie & store data in the DB
                              if ($inputs['remember_me_registeration'] === 1) {
                                        $is_userInfo_store = $authentication_model->store_user_info($last_inserted_id, $inputs['username']);
                              }
                              if ($is_userInfo_store) {
                                        return $this->load_Authentication_Page("Authentication/Registered_Sussfully", [
                                                  'username' => $inputs['username'],
                                                  'email' => $inputs['email'],
                                                  'password' => $inputs['password'],
                                        ]);
                              }
                    }
          }


          private function validateRegistrationInputs(array $inputs): array
          {
                    $errors = [];
                    if (empty($inputs['username'])) {
                              $errors['username'] = 'Username is required';
                    } else if (!preg_match('/^[A-Z][a-z]+(?:\s[A-Z][a-z]+)*$/', $inputs['username'])) {
                              $errors['username'] = 'Username should be in format like "Ahmar Iftikhar"';
                    }

                    if (empty($inputs['email'])) {
                              $errors['email'] = 'Email is required';
                    }

                    if (empty($inputs['password'])) {
                              $errors['password'] = 'Password is required';
                    } else if (strlen($inputs['password']) < 8) {
                              $errors['password'] = 'Password should be at least 8 characters';
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
                    $remember_me = filter_input(INPUT_POST, 'remember_me', FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
                    // Call validation method to check for errors
                    $errors = $this->validateLogin($email, $password);

                    // If there are errors, load the view with errors
                    if (!empty($errors)) {
                              return $this->load_Authentication_Page('Authentication/AuthenticationView', ["errors" => $errors]);
                    }

                    $authentication_model = new AuthenticationModel();
                    $isAuthenticated = $authentication_model->authenticate($email, $password);

                    if ($isAuthenticated) {
                              $is_userInfo_store = $authentication_model->store_user_info($isAuthenticated['id'], $isAuthenticated['username']);
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
          public function google_client_config()
          {
                    // Initialize Google Client
                    $this->client = new \Google_Client();
                    $this->client->setClientId($_ENV['CLIENT_ID']);
                    $this->client->setClientSecret($_ENV['CLIENT_SECRET']);
                    $this->client->setRedirectUri('http://localhost:8000/authentication');

                    $this->client->addScope('email');
                    $this->client->addScope('profile');

                    return $this->client->createAuthUrl();
          }

          public function handle_google_login()
          {
                    // Reinitialize Google Client
                    $client = new \Google_Client();
                    $client->setClientId($_ENV['CLIENT_ID']);
                    $client->setClientSecret($_ENV['CLIENT_SECRET']);
                    $client->setRedirectUri('http://localhost:8000/authentication');
                    try {
                              $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

                              if (array_key_exists('error', $token) && $token['error'] === 'invalid_grant') {
                                        throw new Exception('Access token not found in response: ' . json_encode($token['error_description']));
                              }
                              $client->setAccessToken($token['access_token']);

                              // Get user profile
                              $google_oauth = new \Google_Service_Oauth2($client);
                              $google_account_info = $google_oauth->userinfo->get();

                              // Extract user details
                              $email = $google_account_info->email;
                              $name = $google_account_info->name;
                              $profile_pic = $google_account_info->picture;

                              $authentication_model = new AuthenticationModel();

                              $is_user_already_registered = $authentication_model->is_user_already_registered($email);

                              $isAuthenticated = false;
                              if (!$is_user_already_registered) {
                                        $isAuthenticated = $authentication_model->google_login($name, $email, $profile_pic);
                              } elseif ($is_user_already_registered) {
                                        $isAuthenticated = $authentication_model->store_user_info($is_user_already_registered['id'], $name);

                              } else {
                                        throw new Exception('Failed to store user information.');
                              }
                              if ($isAuthenticated) {
                                        $store_profile_img = $authentication_model->store_profile_img($email, $profile_pic);
                                        if ($store_profile_img) {
                                                  return [
                                                            "email" => $email,
                                                            "password" => null,
                                                  ];
                                        }
                                        throw new Exception('Failed to store user profile image.');
                              }
                    } catch (Throwable $e) {
                              // Handle error or invalid request
                              throw $e;
                    }

          }

}


