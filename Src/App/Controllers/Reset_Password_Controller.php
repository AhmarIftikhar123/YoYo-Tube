<?php
namespace Src\App\Controllers;

use Src\App\Models\Authentication\Forgat_Password_Model;
use Src\App\Views;

class Reset_Password_Controller
{

          public function load_Reset_Password_Page(string $path = "Authentication/Reset_Password_View", array $data = []): Views
          {
                    return Views::make($path, $data);
          }
          public function reset_Password(): Views
          {
                    $token = $_POST['token'] ?? null;
                    if (!$token) {
                              return $this->load_Reset_Password_Page("Authentication/Reset_Password_View", [
                                        'error' => 'We didn\'t receive a password reset token from your request. Please try again.',
                              ]);
                    }

                    $forgatPasswordModel = new Forgat_Password_Model();
                    $isTokenValid = $forgatPasswordModel->validateToken($token);
                    if (!$isTokenValid) {
                              return $this->load_Reset_Password_Page("Authentication/Reset_Password_View", [
                                        'error' => 'The password reset link is invalid or has expired. Please try again.',
                              ]);
                    }

                    $errors = $this->validateResetPasswordInputs($_POST);
                    if (!empty($errors)) {
                              return $this->load_Reset_Password_Page("Authentication/Reset_Password_View", $errors);
                    }

                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                    $confirmPassword = filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_SPECIAL_CHARS);

                    if ($password !== $confirmPassword) {
                              return $this->load_Reset_Password_Page("Authentication/Reset_Password_View", [
                                        'error' => 'Passwords do not match.',
                              ]);
                    }

                    $isPasswordUpdated = $forgatPasswordModel->storeNewPassword($email, $password);

                    if ($isPasswordUpdated) {
                              return $this->load_Reset_Password_Page("Authentication/Reset_Password_Successful_View", [
                                        'password' => $password,
                              ]);
                    }
          }

          private function validateResetPasswordInputs(array $inputs): array
          {
                    $errors = [];
                    if (empty($inputs['email'])) {
                              $errors['email'] = 'Email is required';
                    }
                    if (empty($inputs['password'])) {
                              $errors['password'] = 'Password is required';
                    }
                    if (empty($inputs['confirm-password'])) {
                              $errors['confirm_password'] = 'Confirm password is required';
                    }

                    return $errors;
          }
}

