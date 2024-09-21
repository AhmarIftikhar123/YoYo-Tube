<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>YoYo Tube Navigation</title>
          <style>
                    body {
                              background-color: #121212;
                              color: #e0e0e0;
                    }

                    .navbar {
                              background-color: #1f1f1f;
                    }

                    .navbar-brand {
                              font-weight: bold;
                              font-size: 1.5rem;
                    }

                    .nav-link {
                              color: #e0e0e0 !important;
                              transition: color 0.3s ease;
                    }

                    .nav-link:hover,
                    .nav-link.active {
                              color: #000 !important;
                              background: #fff;
                              border-radius: .5rem;
                    }

                    @media (max-width: 991.98px) {
                              .navbar-nav {
                                        background-color: #1f1f1f;
                                        padding: 10px;
                                        border-radius: 5px;
                              }
                    }
          </style>
</head>

<body>
          <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container">
                              <a class="navbar-brand" href="">YoYo Tube</a>
                              <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                        aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarNav">
                                        <ul class="navbar-nav gap-4 ms-auto align-items-center">
                                                  <li class="nav-item text-center">
                                                            <a class="nav-link px-2" href="#" id="uploadVideo">Upload
                                                                      Video</a>
                                                  </li>
                                                  <li class="nav-item text-center">
                                                            <a class="nav-link px-2" href="#" id="yourVideos">Your
                                                                      Videos</a>
                                                  </li>
                                                  <li class="nav-item text-center">
                                                            <a class="nav-link px-2" href="#" id="searchVideos">Search
                                                                      Videos</a>
                                                  </li>
                                                  <li class="nav-item text-center">
                                                            <a class="nav-link px-2" href="#" id="profile">Profile</a>
                                                  </li>
                                                  <li class="nav-item text-center">
                                                            <a class="nav-link px-2" href="#" id="admin">Admin</a>
                                                  </li>
                                        </ul>
                              </div>
                    </div>
          </nav>

          <script>
                    $('.nav-link').click(function (e) {
                              e.preventDefault();
                              $('.nav-link').removeClass('active');
                              $(this).addClass('active');
                    });

                    $('.navbar-nav>li>a').on('click', function () {
                              $('.navbar-collapse').collapse('hide');
                    });

                    // var path = window.location.pathname;
                    // var page = path.split("/").pop();
                    // console.log(page);

                    // $('.navbar-nav .nav-link').each(function () {
                    //           var href = $(this).attr('href');
                    //           if (href === page || href === '#' + page) {
                    //                     $(this).addClass('active');
                    //           }
                    // });
          </script>
</body>

</html>