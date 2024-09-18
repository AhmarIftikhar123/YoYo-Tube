<?php session_start();
$token = $_GET['token'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Reset Password</title>
          <!-- Bootstrap CSS CDN -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              /* Dark background */
                              color: #e0e0e0;
                              /* Light text for better readability */
                    }

                    .card {
                              background-color: #1e1e1e;
                              /* Dark card background */
                              color: #e0e0e0;
                              /* Light text inside the card */
                              border: none;
                    }

                    .btn-primary {
                              background-color: #1e88e5;
                              /* Lighter button color for dark theme */
                              border-color: #1e88e5;
                    }

                    .btn-primary:hover {
                              background-color: #1565c0;
                              /* Darker button hover color */
                              border-color: #1565c0;
                    }

                    .form-control {
                              background-color: #2c2c2c;
                              /* Darker input field */
                              color: #e0e0e0;
                              /* Light text inside input field */
                              border: 1px solid #3c3c3c;
                    }

                    .form-control:focus {
                              background-color: #2c2c2c;
                              color: #e0e0e0;
                              border-color: #1e88e5;
                              box-shadow: none;
                    }

                    .card-title {
                              color: #4caf50;
                    }

                    .error-message {
                              color: #ff5252;
                              margin-bottom: 10px;
                    }
          </style>
</head>

<body>
          <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
                              <div class="card-body">
                                        <h1 class="card-title text-center mb-3">Reset Password</h1>

                                        <!-- Error message for token not found -->
                                        <h5 class="error-message text-center">
                                                  <?= htmlspecialchars($this->error ?? "") ?>
                                        </h5>

                                        <form method="POST"
                                                  action="/auth/reset-password?token=<?= htmlspecialchars($token) ?>">
                                                  <div class="mb-2">
                                                            <label for="email" class="form-label">Your Email</label>
                                                            <input type="email" class="form-control text-white bg-dark"
                                                                      readonly id="email" name="email"
                                                                      value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "" ?>"
                                                                      style="cursor: not-allowed">
                                                  </div>
                                                  <div class="mb-2">
                                                            <small
                                                                      class="text-danger"><?= htmlspecialchars($this->email) ?? "" ?></small>
                                                  </div>
                                                  <div class="mb-2">
                                                            <input type="hidden" name="token"
                                                                      value="<?= htmlspecialchars($token) ?? "" ?>">
                                                  </div>
                                                  <div class="mb-2">
                                                            <label for="password" class="form-label">New
                                                                      Password</label>
                                                            <input type="password" class="form-control" id="password"
                                                                      name="password">
                                                  </div>
                                                  <div class="mb-2">
                                                            <small
                                                                      class="text-danger"><?= htmlspecialchars($this->password) ?? "" ?></small>
                                                  </div>
                                                  <div class="mb-2">
                                                            <label for="confirm_password" class="form-label">Confirm New
                                                                      Password</label>
                                                            <input type="password" class="form-control"
                                                                      id="confirm_password" name="confirm-password">
                                                  </div>
                                                  <div class="mb-2">
                                                            <small
                                                                      class="text-danger"><?= htmlspecialchars($this->confirm_password) ?? "" ?></small>
                                                  </div>
                                                  <button type="submit" class="btn btn-light my-1 w-100">Reset
                                                            Password</button>
                                        </form>

                                        <!-- Bootstrap JS Bundle with Popper -->
                                        <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>

</body>

</html>
<?php session_write_close(); ?>