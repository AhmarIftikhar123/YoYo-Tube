<?php $uri = explode(
          "?",
          $_SERVER["REQUEST_URI"]
)[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Login & Signup</title>
          <link rel="stylesheet" href="/css/4-pages/Authentication.css">
</head>

<body>
          <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>
          <div class="container d-grid form_wrapper">
                    <ul class="nav nav-tabs justify-content-between" id="authTabs" role="tablist">
                              <li class="nav-item" role="presentation">
                                        <a class="nav-link w-100 border-0
                                        <?= $uri === "/auth/login" || $uri === "/authentication" ? "active" : "" ?>
                                                                               p_block_75" id="login-tab" data-bs-toggle="tab"
                                                  href="#login" role="tab" aria-controls="login"
                                                  aria-selected="true">Login</a>
                              </li>
                              <li class="nav-item" role="presentation">
                                        <a class="nav-link w-100 border-0
                                        <?= $uri === "/auth/register" ? "active" : "" ?>
                                        p_block_75" id="register-tab" data-bs-toggle="tab" href="#register" role="tab"
                                                  aria-controls="register" aria-selected="false">Register</a>
                              </li>
                    </ul>

                    <div class="tab-content mt-3" id="authTabsContent">
                              <!-- Login Tab Content -->
                              <div class="tab-pane 
                              <?= $uri === "/auth/login" || $uri === "/authentication" ? "show active" : "" ?>"
                                        id="login" role="tabpanel" aria-labelledby="login-tab">
                                        <form action="/auth/login" method="POST" class="m_block_125">
                                                  <div class="mb-1 form-group">
                                                            <label for="login-email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="login-email"
                                                                      name="email" placeholder="Enter your email"
                                                                      value="<?= $this->email ?? '' ?>">
                                                            <!-- Error Message for Email -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->errors["email"] ?? "" ?>
                                                            </div>
                                                  </div>

                                                  <div class="mb-3 form-group">
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
                                                  <div class="mb-3 form-check">
                                                            <input type="checkbox" id="remember_me"
                                                                      class="form-check-input" name="remember_me">
                                                            <label for="remember_me" class="form-check-label">
                                                                      Remember Me (Stay login for 7 days )</label>
                                                  </div>

                                                  <button type="submit" name="login"
                                                            class="btn btn-primary w-100 fs_90">Login</button>

                                                  <div class="text-center mt-2">
                                                            <a href="/auth/forgot-password"
                                                                      class="text-underline nav-link mx-auto">Forgot
                                                                      password?</a>
                                                  </div>
                                        </form>
                              </div>

                              <!-- Register Tab Content -->
                              <div class="tab-pane fade
                              <?= $uri === "/auth/register" ? "show active" : "" ?>
                              " id="register" role="tabpanel" aria-labelledby="register-tab">
                                        <form action="/auth/register" method="POST" class="m_block_125">
                                                  <div class="mb-3 form-group">
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

                                                  <div class="mb-3 form-group">
                                                            <label for="register-email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="register-email"
                                                                      name="email" placeholder="Enter your email"
                                                                      value="<?= $this->email ?? '' ?>">
                                                            <!-- Error Message for Email -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->emailError ?? "" ?>
                                                            </div>
                                                  </div>
                                                  <div class="password_wrapper d-grid">
                                                  <div class="mb-2 form-group">
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

                                                  <div class="mb-2 form-group">
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
                                                  </div>
                                                  <div class="mb-3 form-group">
                                                            <label for="confirm-password"
                                                                      class="form-label">Role</label>
                                                            <input type="text" class="form-control" id="role"
                                                                      name="role" placeholder="Role Default is User"
                                                                      list="role-list">
                                                            <datalist id="role-list">
                                                                      <option value="admin"></option>
                                                                      <option value="user"></option>
                                                            </datalist>
                                                            <!-- Error Message for Confirm Password -->
                                                            <div class="text-danger mt-2">
                                                                      <?= $this->confirm_passwordError ?? "" ?>
                                                            </div>

                                                  </div>
                                                  <div class="mb-3 form-check">
                                                            <input type="checkbox" id="remember_me_registeration"
                                                                      class="form-check-input"
                                                                      name="remember_me_registeration">
                                                            <label for="remember_me_registeration"
                                                                      class="form-check-label">
                                                                      Remember Me (Stay login for 7 days )</label>
                                                  </div>

                                                  <button type="submit"
                                                            class="btn btn-primary w-100 fs_90">Register</button>
                                        </form>
                              </div>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="mt-2">
                              <a href="<?= $this->google_client_config ?? '' ?>"
                                        class="btn btn-secondary w-100 mb-2 mx-1 fs_90">
                                        <img src="/images/google.png" class="me-2 google_icon" alt="loading-google-icon"> Continue with Google
                              </a>
                    </div>
          </div>
</body>

</html>
<?php session_write_close(); ?>