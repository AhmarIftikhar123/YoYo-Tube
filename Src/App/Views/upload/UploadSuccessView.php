<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Registration Success</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              color: #e0e0e0;
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              height: 100vh;
                              margin: 0;
                    }

                    .container {
                              max-width: 500px;
                              text-align: center;
                    }

                    .btn-custom {
                              margin: 10px;
                    }
          </style>
</head>

<body>
          <div class="container">
                    <h1 class="mb-4">Upload Successful!</h1>
                    <p class="mb-4">Thank you for uploading your video. Here are the details:</p>
                    <p class="mb-2"><strong class="text-info">File Name: </strong> <span
                                        id="fileName"><?= htmlspecialchars($this->file_name) ?? "" ?></span></p>
                    <p class="mb-4"><strong class="text-info">Category:</strong> <span id="videoCategory">Video
                                        Category:
                                        <?= htmlspecialchars($this->video_category) ?? "" ?></span></p>

                    <div>
                              <a href="/user-posts" class="btn btn-light btn-custom">See Your Posts</a>
                              <a href="/" class="btn btn-secondary btn-custom">Go to Home Page</a>
                    </div>
          </div>

</body>

</html>