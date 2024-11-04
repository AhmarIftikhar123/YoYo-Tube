<?php
$HomeModel = $this->HomeModel;

$filter_type = isset($_GET["filter"]) ? str_replace(' ', '+', $_GET["filter"]) : "action";

$offset = !isset($_GET["page"]) ? 0 : ((int) $_GET["page"] - 1) * 8;

$current_post_info = $HomeModel->get_current_post_info($offset, 8, $filter_type);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YoYo Tube</title>
    <link rel="stylesheet" href="/css/4-pages/HomeView.css">
    <style>
        .card {
            transition: transform 0.2s;
            background-color: var(--card-bg);
            color: var(--card-text);
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

            .card-title {
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
            background-color: var(--footer-bg);
            color: var(--footer-text);
        }

        .footer a {
            color: var(--footer-text);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .page-link {
            background: var(--card-bg) !important;
            color: var(--text-color) !important;
            border: gray 1px solid !important;

            &.active {
                background: var(--text-color) !important;
                color: var(--bg-color) !important;
                border: gray 1px solid !important;
            }
        }

        .form-select,
        .form-check-input {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--text-color);
        }

        .btn-light {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--text-color);
        }

        .btn-light:hover {
            background-color: var(--text-color);
            color: var(--bg-color);
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include dirname(__DIR__) . "/nav/Nav.php"; ?>

    <!-- Main Content -->
    <div class="container my-3">
        <!-- Search Iput -->
        <div class="container">

            <div class="input-group my-3 mx-auto align-items-ceter justify-content-center">
                <input type="text" name="search" class="form-control rounded-start
                bg_darkest_black clr_aqua" id="searchInput" placeholder="Search Videos..." list="filterDetails">
                <button class="btn btn-primary rounded-end" type="button" id="searchBtn"><i
                        class="fa-solid fa-magnifying-glass"></i></i></button>
                <datalist id="filterDetails">
                </datalist>
            </div>
            <small class="text-danger text-center d-block ms-2 mb-2 fs_75" id="searchError"></small>
        </div>

        <!-- Video Grid -->
        <div id="videoGrid" class="row">
            <!-- Video cards will be dynamically inserted here -->

            <?php foreach ($current_post_info as $post): ?>

                <div class="col-md-3 mb-2">
                    <div class="card">
                        <img src="<?= $post['thumbnail_path'] ?>" alt="vidoe_thumbnail" style="height: 200px;">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <a href="/videos/watch?video_id=<?= $post['id'] ?>&user_id=<?= $post['user_id'] ?>&is_paid=<?= $post['is_paid'] ?>"
                                target="_blank" class="btn btn-light btn-lg rounded-circle">
                                <i class="bi bi-play-fill"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $post['title'] ?></h5>
                            <p class="card-text text-uppercase d-flex gap-2">
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
    <?php
    $all_posts_info = !isset($filter_type) ? $HomeModel->get_all_posts_info() : $HomeModel->get_all_posts_info($filter_type);
    $current_page = $_GET['page'] ?? 1;
    $number_of_pages = ceil(count($all_posts_info) / 8);
    ?>

    <nav aria-label="Video pagination" class="pagination pagination-dark align-items-center justify-content-center ">
        <ul class="pagination">
            <li class="page-item">
                <a href="/home?page=<?= $current_page - 1 ?>" class="page-link" tabindex="-1" aria-disabled="true"
                    style="<?= $current_page > 1 ? "" : "display: none" ?>">
                    <span class="visually-hidden">Previous</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </a>
            </li>
            <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                <li class="page-item" aria-current="page">
                    <a href="/home?page=<?= $i ?>&filter=<?= $filter_type ?>"
                        class="page-link <?= $i == $current_page ? "active" : "" ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item">
                <a href="/home?page=<?= $current_page + 1 ?>" class="page-link" tabindex="-1" aria-disabled="true"
                    style="<?= $current_page < $number_of_pages ? "" : "display: none" ?>">
                    <span class="visually-hidden">Next</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </a>
            </li>
        </ul>
    </nav>
    </div>
    <!-- Footer -->
    <footer class="footer mt-5 py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>YoYo Tube</h5>
                    <p>Share and enjoy amazing home!</p>
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
    <script>
        function debounce(func, delay = 500) {
            let timer;
            return function (...args) {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }
        const searchDebounce = debounce((query) => {
            $.ajax({
                url: "<?= BASE_URL . "/home/search" ?>",
                method: "POST",
                data: {
                    query: query
                },
                success: function (response) {
                    console.log(response);
                    if (response.success && Array.isArray(response.suggestions)) {
                        response.suggestions.forEach((suggestion) => {
                            $('#filterDetails').append(`<option value='${suggestion}'></option>`);
                        })
                    } else {
                        $('#searchError').text(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            })
        }, 500)
        function redirectToSearch(query) {
            if (query) {
                window.location.href = `/home?filter=${query}`; // Redirect to search page with query
            }
        }
        const searchInput = $("#searchInput");
        const searchBtn = $('#searchBtn');
        // Event listener for input changes
        searchInput.on("input", function (event) {
            event.preventDefault();
            const query = searchInput.val();
            if (query.length > 0) {
                $('#filterDetails').empty();
                $('#searchError').text(""); // Clear error message
                searchDebounce(query.toLowerCase());
            }
        });

        // Event listener for "Enter" key on the input field
        searchInput.on("keypress", function (event) {
            if (event.key === 'Enter') {
                const query = searchInput.val().trim();
                redirectToSearch(query);
            }
        });
        // Search Button
        searchBtn.on('click', function () {
            const query = searchInput.val().trim();
            redirectToSearch(query);
        });
    </script>
</body>

</html>
<?php session_write_close(); ?>