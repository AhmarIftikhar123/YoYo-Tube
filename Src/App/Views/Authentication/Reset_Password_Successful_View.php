<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Password Reset Successful</title>
          <!-- Bootstrap CSS -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              color: #e0e0e0;
                    }

                    .container {
                              margin-top: 50px;
                    }

                    .card {
                              background-color: #1e1e1e;
                              border: 1px solid #333;
                              box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                    }

                    .btn-primary {
                              background-color: #4CAF50;
                              border-color: #4CAF50;
                    }

                    .btn-primary:hover {
                              background-color: #45a049;
                              border-color: #45a049;
                    }
          </style>
</head>

<body>
          <div class="container">
                    <div class="card">
                              <div class="card-body text-center">
                                        <h1 class="card-title mb-4 text-white">Password Reset Successful</h1>
                                        <p class="card-text mb-4 text-white">Your password has been reset successfully.
                                                  Your New Password is : </p>
                                        <p class="text-success fw-bold fst-italic"><?= $this->password ?></p>
                                        <p class="card-text mb-4 text-white">
                                                  You can now
                                                  use your new Password to log in.</p>

                                        <a href="/Authentication" class="btn btn-light fw-bold">Go to Login Page</a>
                              </div>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>

</body>

</html>