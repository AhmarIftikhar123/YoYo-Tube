<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>User Profile</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              /* Dark background */
                              color: #e0e0e0;
                              /* Light text color */
                    }

                    .container-custom {
                              max-width: 800px;
                              margin: 0 auto;
                              padding: 2rem 1rem;
                    }

                    .avatar {
                              width: 96px;
                              height: 96px;
                              border-radius: 50%;
                              overflow: hidden;
                              background-color: #333;
                              display: flex;
                              align-items: center;
                              justify-content: center;
                    }

                    .avatar img {
                              width: 100%;
                              height: 100%;
                              object-fit: cover;
                    }

                    .avatar-fallback {
                              color: #e0e0e0;
                              font-size: 1.5rem;
                    }

                    .card-custom {
                              background-color: #1e1e1e;
                              /* Darker card background */
                              border: 1px solid #333;
                              /* Card border */
                              color: #e0e0e0;
                              /* Light text color */
                    }

                    .btn-custom {
                              background-color: #007bff;
                              /* Bootstrap primary color */
                              border-color: #007bff;
                    }

                    .btn-custom:hover {
                              background-color: #0056b3;
                              /* Darker blue on hover */
                              border-color: #0056b3;
                    }

                    .form-label {
                              color: #e0e0e0;
                              /* Light text color for labels */
                    }
          </style>
</head>

<body>
          <div class="container container-custom">
                    <h1 class="text-2xl font-bold mb-6">User Profile</h1>
                    <div class="card card-custom p-4">
                              <div class="d-flex align-items-center mb-4">
                                        <div class="avatar">
                                                  <img src="/placeholder.svg?height=96&width=96" alt="User Avatar">
                                                  <div class="avatar-fallback">UN</div>
                                        </div>
                                        <button class="btn btn-custom ms-4">Change Avatar</button>
                              </div>
                              <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" id="username" class="form-control" value="JohnDoe123">
                              </div>
                              <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" value="johndoe@example.com">
                              </div>
                              <div class="mb-3">
                                        <label for="bio" class="form-label">Bio</label>
                                        <textarea id="bio" class="form-control" rows="3"
                                                  placeholder="Tell us about yourself..."></textarea>
                              </div>
                              <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" id="password" class="form-control"
                                                  placeholder="Enter new password">
                              </div>
                              <div class="mb-3">
                                        <label for="confirm-password" class="form-label">Confirm New Password</label>
                                        <input type="password" id="confirm-password" class="form-control"
                                                  placeholder="Confirm new password">
                              </div>
                              <button class="btn btn-custom w-100">Save</button>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
</body>

</html>