<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>404 - Page Not Found</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    .container-custom {
                              max-width: 600px;
                              margin: 0 auto;
                              text-align: center;
                    }

                    .btn-custom {
                              padding: 0.5rem 2rem;
                              font-size: 1.125rem;
                    }
          </style>
</head>

<body class="text-white bg-dark row align-items-center justify-content-center overflow-hidden" style="height: 100vh;">
          <div class="container container-custom">
                    <h3 class="display-7 mb-4 fw-bolder">Error : <?= $this->message ?></h3>
                    <p class="lead mb-8">Oops! The page you're looking for doesn't exist.</p>
                    <p class="lead mb-8 text-italic"></p>
                    <a href="/" class="btn btn-light fw-bold">Go back home</a>
          </div>

          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
</body>

</html>