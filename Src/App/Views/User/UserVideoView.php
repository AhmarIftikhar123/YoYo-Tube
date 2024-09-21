<?php
$user_video_model = $this->user_video_model;
$user_id = $_SESSION["user_id"];
$get_user_posts = $user_video_model->get_user_posts($user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube - Video Listing</title>
    <?php include dirname(__DIR__) . "/partials/Bootstrap_css.php"; ?>
    <?php include dirname(__DIR__) . "/partials/jquery_js.php"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #ff6b6b !important;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card-img-overlay {
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .card:hover .card-img-overlay {
            opacity: 1;
        }

        .card-body {

            &>.card-title,
            .card-text {

                text-overflow: ellipsis;
                overflow: hidden;
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
            }
            .card-title{
                min-height: 3rem;
            }
        }

        .card-text:nth-child(3) {
            min-height: 7.5rem;
            -webkit-line-clamp: 5 !important;
        }

        .badge-paid {
            background-color: #ffc107;
            color: #000;
        }

        .badge-free {
            background-color: #28a745;
            color: #fff;
        }

        .star-rating {
            color: #ffc107;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Filter Panel -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-4 mb-4">
                <select class="form-select" id="categoryFilter">
                    <option selected>Action (default)</option>
                    <option>Comedy</option>
                    <option>Drama</option>
                    <option>Horror</option>
                </select>
            </div>
            <div class="col-md-4 mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="adultContentSwitch">
                    <label class="form-check-label" for="adultContentSwitch">18+
                        Content</label>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <button class="btn btn-light w-100" id="applyFilters">Apply Filters</button>
            </div>
        </div>

        <!-- Video Grid -->
        <div class="row" id="videoGrid">
            <!-- Video cards will be dynamically inserted here -->

            <div id="videoGrid" class="row">
                <?php foreach ($get_user_posts as $post): ?>

                    <div class="col-md-3 mb-4">
                        <!-- <video src="<?= $post['file_path'] ?>" class="card-img-top" alt="Awesome Yoyo Tricks"> -->
                        <div class="card">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <a href="/videos?id=<?= $post['id'] ?>" target="_blank"
                                    class="btn btn-light btn-lg rounded-circle">
                                    <i class="bi bi-play-fill"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $post['title'] ?></h5>
                                <p class="card-text">
                                    <span class="badge bg-secondary"><?= $post['category'] ?></span>
                                    <span
                                        class="badge badge-<?= $post['is_paid'] ? 'paid' : 'free' ?>"><?= $post['is_paid'] ? 'Paid' : 'Free' ?></span>
                                </p>
                                <p class="card-text"><?= $post['description'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <!-- Footer -->
    <footer class="footer mt-5 py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>YoYo Tube</h5>
                    <p>Share and enjoy amazing videos!</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <?php include dirname(__DIR__) . "/partials/Bootstrap_js.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
                    let currentPage = 1;
                    const videosPerPage = 8;

                    // Function to generate a single video card
                    function generateVideoCard(video) {
                              return `
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="${video.thumbnail}" class="card-img-top" alt="${video.title}">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <button class="btn btn-primary btn-lg rounded-circle">
                                    <i class="bi bi-play-fill"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">${video.title}</h5>
                                <p class="card-text">
                                    <span class="badge bg-secondary">${video.category}</span>
                                    <span class="badge ${video.paid ? 'badge-paid' : 'badge-free'}">${video.paid ? 'Paid' : 'Free'}</span>
                                </p>
                                <div class="star-rating">
                                    ${'★'.repeat(video.rating)}${'☆'.repeat(5 - video.rating)}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    }

                    // Function to load videos
                    function loadVideos(page) {
                              // This is where you would typically make an AJAX call to your backend
                              // For this example, we'll use dummy data
                              const dummyVideos = [
                                        { title: "Awesome Yoyo Tricks", thumbnail: "https://via.placeholder.com/300x200", category: "Entertainment", paid: false, rating: 4 },
                                        { title: "Pro Yoyo Competition", thumbnail: "https://via.placeholder.com/300x200", category: "Sports", paid: true, rating: 5 },
                                        { title: "Learn Basic Yoyo Skills", thumbnail: "https://via.placeholder.com/300x200", category: "Education", paid: false, rating: 3 },
                                        { title: "Yoyo History Documentary", thumbnail: "https://via.placeholder.com/300x200", category: "Documentary", paid: true, rating: 4 },
                                        { title: "Extreme Yoyo Stunts", thumbnail: "https://via.placeholder.com/300x200", category: "Action", paid: false, rating: 5 },
                                        { title: "Yoyo Meditation Techniques", thumbnail: "https://via.placeholder.com/300x200", category: "Lifestyle", paid: true, rating: 3 },
                                        { title: "DIY Yoyo Crafting", thumbnail: "https://via.placeholder.com/300x200", category: "DIY", paid: false, rating: 4 },
                                        { title: "Yoyo Physics Explained", thumbnail: "https://via.placeholder.com/300x200", category: "Science", paid: true, rating: 5 }
                              ];

                              const startIndex = (page - 1) * videosPerPage;
                              const endIndex = startIndex + videosPerPage;
                              const pageVideos = dummyVideos.slice(startIndex, endIndex);

                              let videoHTML = '';
                              pageVideos.forEach(video => {
                                        videoHTML += generateVideoCard(video);
                              });

                              if (page === 1) {
                                        $('#videoGrid').html(videoHTML);
                              } else {
                                        $('#videoGrid').append(videoHTML);
                              }

                    }

                    // Initial load
                    loadVideos(currentPage);

                    // Apply Filters button click event
                    $('#applyFilters').on('click', function () {
                              const category = $('#categoryFilter').val(); const adultContent = $('#adultContentSwitch').is(':checked');

                              // Here you would typically send these filters to your backend
                              // For this example, we'll just reset the video grid
                              currentPage = 1;
                              loadVideos(currentPage);

                              console.log('Filters applied:', { category, adultContent });
                    });
          </script> -->
</body>

</html>
<?php session_write_close(); ?>