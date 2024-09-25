<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Login Successful</title>
          <!-- Bootstrap CSS -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body,
                    html {
                              height: 100%;
                              place-items: center;
                              background-color: #1c1c1c;
                              color: #f8f9fa;
                    }

                    .success-container {
                              max-width: 400px;
                              padding: 30px;
                              background-color: #2c2c2c;
                              border-radius: 10px;
                              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                    }

                    .btn-home {
                              background-color: #007bff;
                              color: #fff;
                              border: none;
                              border-radius: 5px;
                              cursor: pointer;
                              transition: background-color 0.3s ease;
                    }

                    .btn-home:hover {
                              background-color: #0056b3;
                    }
          </style>
</head>

<body class="d-grid">

          <div class="success-container text-center overflow-hidden">
                    <h2 class="mb-4 text-success">Login Successful</h2>
                    <div class="info bg-dark p-3 rounded text-start">
                              <p><strong class="text-info">Email:</strong> <span id="user-email"
                                                  class="text-light"><?= htmlspecialchars($this->email); ?></span></p>
                              <p><strong class="text-info">Password:</strong>
                                        <span id="user-password" class="text-light">
                                                  <?= isset($this->password) ? htmlspecialchars(substr($this->password, 0, 15)) . '...' : 'Password not visible if you login using google or facebook account' ?>
                                        </span>
                              </p>
                    </div>
                    <a href="/" class="btn btn-light fw-bold mt-3 w-100" id="go-home-btn">Home Page</a>
          </div>

          <!-- Bootstrap JS and jQuery -->
          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>

</body>

</html>