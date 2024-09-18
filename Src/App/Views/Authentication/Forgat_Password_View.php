<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Forgot Password</title>

          <!-- Include Bootstrap CSS -->
          <?php include dirname(__DIR__) . "/partials/Font_Awesome.php"; ?>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <link rel="stylesheet" href="/css/Auth.css">
          <style>
                    .container-custom {
                              max-width: 500px;
                              margin: 0 auto;
                              padding: 2rem 1rem;
                    }
          </style>
</head>

<body class="d-grid">
          <!-- Main container -->
          <div class="container container-custom">
                    <h1 class="text-center mb-4">Forgot Password</h1>
                    <form id="forgotPasswordForm" method="post" action="/auth/forgot-password">
                              <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                                  placeholder="Enter your email">
                                        <div id="emailError" class="text-danger mt-2">
                                                  <?= htmlspecialchars($this->emailError) ?>
                                        </div>
                              </div>
                              <button type="submit" class="btn btn-light w-100">Reset Password</button>
                    </form>
          </div>

          <!-- Include Bootstrap JS and dependencies -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
          <!-- <script>
                    $('#forgotPasswordForm').on('submit', function (event) {
                              event.preventDefault();
                              let email = $('#email').val();
                              if (email) {
                                        // For now, just alert the email entered
                                        alert('Password reset link sent to: ' + email);
                              }
                    });
          </script> -->
</body>

</html>