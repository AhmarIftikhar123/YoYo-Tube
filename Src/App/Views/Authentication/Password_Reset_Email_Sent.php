<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Password Reset Email Sent</title>
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

                    .card-title {
                              color: #4caf50;
                              /* Green color for success message */
                    }
          </style>
</head>

<body>
          <div class="d-flex justify-content-center align-items-center vh-100">
                    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
                              <div class="card-body text-center">
                                        <h1 class="card-title mb-3">Email Sent Successfully</h1>
                                        <p class="card-text">A password reset link has been sent to your email. Please
                                                  check your inbox.</p>
                                        <a href="https://mail.google.com" target="_blank"
                                                  class="btn btn-light mt-3 fw-bold">Go to Gmail</a>
                              </div>
                    </div>
          </div>

          <!-- Bootstrap JS Bundle with Popper -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>

</body>

</html>