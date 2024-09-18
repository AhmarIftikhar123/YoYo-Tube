<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Admin Dashboard</title>
          <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
          <style>
                    body {
                              background-color: #121212;
                              /* Dark background */
                              color: #e0e0e0;
                              /* Light text color */
                    }

                    .container-custom {
                              max-width: 1200px;
                              margin: 0 auto;
                              padding: 2rem 1rem;
                    }

                    .card-custom {
                              background-color: #1e1e1e;
                              /* Darker card background */
                              border: 1px solid #333;
                              /* Card border */
                              color: #e0e0e0;
                              /* Light text color */
                              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                    }

                    .table-custom {
                              background-color: #1e1e1e;
                              /* Darker table background */
                              color: #e0e0e0;
                              /* Light text color */
                    }

                    .table-custom th,
                    .table-custom td {
                              border: 1px solid #333;
                              /* Table borders */
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
          </style>
</head>

<body>
          <div class="container container-custom">
                    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-8">
                              <div class="col">
                                        <div class="card card-custom p-3">
                                                  <h2 class="card-title">Total Users</h2>
                                                  <p class="card-text display-4">1,234</p>
                                        </div>
                              </div>
                              <div class="col">
                                        <div class="card card-custom p-3">
                                                  <h2 class="card-title">Total Videos</h2>
                                                  <p class="card-text display-4">5,678</p>
                                        </div>
                              </div>
                              <div class="col">
                                        <div class="card card-custom p-3">
                                                  <h2 class="card-title">Reported Videos</h2>
                                                  <p class="card-text display-4">42</p>
                                        </div>
                              </div>
                    </div>
                    <div class="mb-8">
                              <h2 class="text-xl font-semibold mb-4">Recent Users</h2>
                              <table class="table table-custom">
                                        <thead>
                                                  <tr>
                                                            <th>Username</th>
                                                            <th>Email</th>
                                                            <th>Joined</th>
                                                            <th>Action</th>
                                                  </tr>
                                        </thead>
                                        <tbody>
                                                  <tr>
                                                            <td>User1</td>
                                                            <td>user1@example.com</td>
                                                            <td>2023-05-01</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                                  <tr>
                                                            <td>User2</td>
                                                            <td>user2@example.com</td>
                                                            <td>2023-05-02</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                                  <tr>
                                                            <td>User3</td>
                                                            <td>user3@example.com</td>
                                                            <td>2023-05-03</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                        </tbody>
                              </table>
                    </div>
                    <div>
                              <h2 class="text-xl font-semibold mb-4">Recent Videos</h2>
                              <table class="table table-custom">
                                        <thead>
                                                  <tr>
                                                            <th>Title</th>
                                                            <th>Uploader</th>
                                                            <th>Uploaded</th>
                                                            <th>Action</th>
                                                  </tr>
                                        </thead>
                                        <tbody>
                                                  <tr>
                                                            <td>Video Title 1</td>
                                                            <td>User1</td>
                                                            <td>2023-05-01</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                                  <tr>
                                                            <td>Video Title 2</td>
                                                            <td>User2</td>
                                                            <td>2023-05-02</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                                  <tr>
                                                            <td>Video Title 3</td>
                                                            <td>User3</td>
                                                            <td>2023-05-03</td>
                                                            <td><button class="btn btn-custom btn-sm">View</button></td>
                                                  </tr>
                                        </tbody>
                              </table>
                    </div>
          </div>

          <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
</body>

</html>