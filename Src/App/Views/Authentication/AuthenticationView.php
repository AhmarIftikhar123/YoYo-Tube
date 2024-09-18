<?php $uri = $_SERVER["REQUEST_URI"]; ?>
<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Login & Signup</title>
          <?php include dirname(__DIR__) . "/partials/Font_Awesome.php"; ?>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <?php if ($uri === "/auth/login" || $uri === "/auth/register"): ?>
                    <link rel="stylesheet" href="../css/Auth.css">
          <?php else: ?>
                    <link rel="stylesheet" href="/css/Auth.css">
          <?php endif; ?>
</head>

<body class="d-grid">
          <div class="container-md" style="max-width: 768px;">
                    <ul class="nav nav-tabs" id="authTabs" role="tablist">
                              <li class="nav-item" role="presentation">
                                        <a class="nav-link 
                                        <?= $uri === "/auth/login" || $uri === "/authentication" ? "active" : "" ?>
                                                                               " id="login-tab" data-bs-toggle="tab"
                                                  href="#login" role="tab" aria-controls="login"
                                                  aria-selected="true">Login</a>
                              </li>
                              <li class="nav-item" role="presentation">
                                        <a class="nav-link 
                                        <?= $uri === "/auth/register" ? "active" : "" ?>
                                        " id="register-tab" data-bs-toggle="tab" href="#register" role="tab"
                                                  aria-controls="register" aria-selected="false">Register</a>
                              </li>
                    </ul>

                    <div class="tab-content mt-3" id="authTabsContent">
                              <!-- Login Tab Content -->
                              <div class="tab-pane 
                              <?= $uri === "/auth/login" || $uri === "/authentication" ? "show active" : "" ?>"
                                        id="login" role="tabpanel" aria-labelledby="login-tab">
                                        <form action="/auth/login" method="POST">
                                                  <div class="mb-3">
                                                            <label for="login-email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="login-email"
                                                                      name="email" placeholder="Enter your email"
                                                                      value="<?= $this->email ?? '' ?>">
                                                            <!-- Error Message for Email -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->errors["email"] ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <div class="mb-3">
                                                            <label for="login-password"
                                                                      class="form-label">Password</label>
                                                            <input type="password" class="form-control"
                                                                      id="login-password" name="password"
                                                                      placeholder="Enter your password">
                                                            <!-- Error Message for Email -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->errors["password"] ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <button type="submit" name="login"
                                                            class="btn btn-secondary w-100">Login</button>

                                                  <div class="text-center mt-2">
                                                            <a href="/auth/forgot-password"
                                                                      class="text-underline">Forgot password?</a>
                                                  </div>
                                        </form>
                              </div>

                              <!-- Register Tab Content -->
                              <div class="tab-pane fade
                              <?= $uri === "/auth/register" ? "show active" : "" ?>
                              " id="register" role="tabpanel" aria-labelledby="register-tab">
                                        <form action="/auth/register" method="POST">
                                                  <div class="mb-3">
                                                            <label for="register-username"
                                                                      class="form-label">Username</label>
                                                            <input type="text" class="form-control"
                                                                      id="register-username" name="username"
                                                                      placeholder="Enter your username"
                                                                      value="<?= $this->username ?? '' ?>">
                                                            <!-- Error Message for Username -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->usernameError ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <div class="mb-3">
                                                            <label for="register-email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="register-email"
                                                                      name="email" placeholder="Enter your email"
                                                                      value="<?= $this->email ?? '' ?>">
                                                            <!-- Error Message for Email -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->emailError ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <div class="mb-3">
                                                            <label for="register-password"
                                                                      class="form-label">Password</label>
                                                            <input type="password" class="form-control"
                                                                      id="register-password" name="password"
                                                                      placeholder="Create a password">
                                                            <!-- Error Message for Password -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->passwordError ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <div class="mb-3">
                                                            <label for="confirm-password" class="form-label">Confirm
                                                                      Password</label>
                                                            <input type="password" class="form-control"
                                                                      id="confirm-password" name="confirm_password"
                                                                      placeholder="Confirm your password">
                                                            <!-- Error Message for Confirm Password -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->confirm_passwordError ?? "" ?>
                                                            </div>

                                                  </div>

                                                  <button type="submit"
                                                            class="btn btn-secondary w-100">Register</button>
                                        </form>
                              </div>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="mt-4">
                              <button class="btn btn-success w-100 mb-2 mx-1">
                                        <i class="fa-brands fa-google me-2"></i> Continue with Google
                              </button>
                              <button class="btn btn-primary w-100 mx-1">
                                        <i class="fa-brands fa-facebook me-2"></i> Continue with Facebook
                              </button>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
</body>

</html>