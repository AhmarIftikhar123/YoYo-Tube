<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Registration Successful</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              color: #ffffff;
                              font-family: Arial, sans-serif;
                    }

                    .success-icon {
                              font-size: 4rem;
                              color: #28a745;
                    }

                    .card {
                              background-color: #1e1e1e;
                              border: none;
                    }

                    .btn-primary {
                              background-color: #007bff;
                              border-color: #007bff;
                    }

                    .btn-primary:hover {
                              background-color: #0056b3;
                              border-color: #0056b3;
                    }

                    .text-white {
                              color: #fff !important;
                    }

                    .container,
                    .card-body {
                              max-width: 768px;
                    }
          </style>
</head>

<body class="bg-dark text-white">
          <div class="container mt-5">
                    <div class="row justify-content-center">
                              <div class="col-md-8">
                                        <div class="card shadow-lg">
                                                  <div class="card-body text-center">
                                                            <div class="success-icon mb-4">
                                                                      &#10004;
                                                            </div>
                                                            <h2 class="card-title mb-4 text-white">Registration
                                                                      Successful!</h2>
                                                            <p class="card-text text-white">Thank you for registering.
                                                                      Your account
                                                                      has been created successfully.</p>
                                                            <div class="user-info mt-4 text-white">
                                                                      <p><strong class="text-info">Username:</strong>
                                                                                <?= htmlspecialchars($this->username) ?>
                                                                      </p>
                                                                      <p><strong class="text-info">Email:</strong>
                                                                                <?= htmlspecialchars($this->email) ?>
                                                                      </p>
                                                                      <p><strong class="text-info">Password:</strong>
                                                                                <?= htmlspecialchars($this->password) ?>
                                                                      </p>
                                                            </div>
                                                            <a href="/home" class="btn btn-light fw-bold mt-4"
                                                                      id="goHomeBtn">Go to Home</a>
                                                  </div>
                                        </div>
                              </div>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
</body>

</html>