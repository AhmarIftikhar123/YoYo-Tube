<?php
// Function to Format the Date of Upload
function timeAgo($time)
{
    $time_difference = time() - strtotime($time);

    if ($time_difference < 1) {
        return 'Just now';
    }

    $condition = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}
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
                bg_darkest_black  clr_teal" id="searchInput" placeholder="Search Videos..." list="filterDetails">
                <button class="btn btn-primary rounded-end" type="button" id="searchBtn"><i
                        class="fa-solid fa-magnifying-glass"></i></i></button>
                <datalist id="filterDetails">
                </datalist>
            </div>
            <small class="text-danger text-center d-block ms-2 mb-1 fs_75" id="searchError"></small>
        </div>

        <!-- Video Grid -->
        <div id="videoGrid" class="row">
            <!-- Video cards will be dynamically inserted here -->

            <?php foreach ($current_post_info as $post): ?>
                <div class="col-md-4 col-lg-3 mb-2">
                    <div class="card clr_light_gray bg_darkest_black fs_1">
                        <img src="<?= $post['thumbnail_path'] ?>" alt="vidoe_thumbnail" class="card-img-top">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <a href="/videos/watch?video_id=<?= $post['id'] ?>&user_id=<?= $post['user_id'] ?>&is_paid=<?= $post['is_paid'] ?>"
                                target="_blank" class="btn btn-primary p_1 rounded-circle">
                                <i class="fa-solid fa-play"></i> </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-1 fs_1"><?= htmlspecialchars($post['title']) ?></h5>

                            <p class="card-text mb-1 clr_teal fs_85"><?= $post['description'] ?></p>
                            <!-----------------  Channel ----------------->
                        <p class="channel mb-2"><span class="channel_name clr_light_gray">
                                <?= substr(htmlspecialchars($post['username']), 0, 20) ?>...
                                <i class="fa-solid fa-circle-check clr_aqua"></i>
                            </span></p>
                        <!--------------- Price & Time of Upload --------------->
                        <div
                            class="d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                            <?php if ($post['price'] <= 0): ?>
                            <span
                                class="fs_75 clr_darkest_black bg_light_gray mb-1 p_inline_75 p_block_25 rounded">Free</span>
                            <?php else: ?>
                            <span class="fs_75 clr_darkest_black bg_teal mb-1 p_inline_75 p_block_25 rounded">
                                $
                                <?= $post['price'] ?>
                            </span>
                            <?php endif; ?>

                            <span class="fs_75 clr_light_gray  mb-1 p_inline_75 p_block_25">
                                <?= timeAgo($post['updated_at']) ?>
                            </span>
                        </div>
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
                        class="page-link rounded <?= $i == $current_page ? "active" : "" ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item">
                <a href="/home?page=<?= $current_page + 1 ?>" class="page-link " tabindex="-1" aria-disabled="true"
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
    <?php include dirname(__DIR__) . "/partials/footer.php"; ?>
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